<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * ログインフォーム表示
     */
    public function index(Request $request)
    {
        // デバッグ情報をログに記録
        Log::info('Login form access', [
            'session_id' => session()->getId(),
            'csrf_token' => csrf_token(),
            'error_id' => $request->get('error_id')
        ]);

        return view('auth.login', [
            'error_id' => $request->get('error_id')
        ]);
    }

    /**
     * ログアウト処理
     */
    public function logout(Request $request)
    {
        // セッションを完全にクリア
        Session::flush();

        // セッションを再生成（セキュリティ向上）
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('User logged out', [
            'session_id' => session()->getId()
        ]);

        return redirect()->route('auth.index')->with('success', 'ログアウトしました');
    }

    /**
     * ログイン処理
     */
    public function login(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:20'],
            'password' => ['required', 'string', 'min:1']
        ]);

        // ユーザー検索
        $account = Accounts::where('name', $validated['name'])->first();

        if (!$account || !Hash::check($validated['password'], $account->password)) {
            return redirect()->route('auth.index')->withErrors(['error' => 'ユーザー名またはパスワードが間違っています。']);
        }

        // セッションに保存
        Session::put([
            'login' => true,
            'user_id' => $account->id,
            'user_name' => $account->name
        ]);

        return redirect('/accounts/home')->with('success', 'ログインしました');
    }

    /**
     * CSRFトークン取得（デバッグ用）
     */
    public function getCsrfToken()
    {
        return response()->json([
            'token' => csrf_token(),
            'session_id' => session()->getId(),
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * セッション確認（デバッグ用）
     */
    public function checkSession()
    {
        return response()->json([
            'session_id' => session()->getId(),
            'login_status' => Session::get('login', false),
            'user_name' => Session::get('user_name'),
            'all_session_data' => Session::all()
        ]);
    }
}
