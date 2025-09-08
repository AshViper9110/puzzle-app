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
        // デバッグ情報をログに記録
        Log::info('Login attempt', [
            'session_id' => session()->getId(),
            'csrf_token_provided' => $request->has('_token'),
            'csrf_token_length' => strlen($request->input('_token', '')),
            'name' => $request->input('name'),
            'has_password' => !empty($request->input('password')),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip()
        ]);

        try {
            // バリデーション
            $validated = $request->validate([
                'name' => ['required', 'string', 'min:4', 'max:20'],
                'password' => ['required', 'string', 'min:1']
            ]);

            Log::info('Validation passed', ['name' => $validated['name']]);

            // ユーザー検索
            $account = Accounts::where('name', $validated['name'])->first();

            if (!$account) {
                Log::warning('Account not found', ['name' => $validated['name']]);
                return redirect()->route('auth.index', ['error_id' => 1]);
            }

            // パスワード確認
            if (!Hash::check($validated['password'], $account->password)) {
                Log::warning('Invalid password', [
                    'name' => $validated['name'],
                    'account_id' => $account->id
                ]);
                return redirect()->route('auth.index', ['error_id' => 2]);
            }

            // ログイン成功
            Session::put('login', true);
            Session::put('user_id', $account->id);
            Session::put('user_name', $account->name);

            // セッション再生成（セキュリティ向上）
            $request->session()->regenerate();

            Log::info('Login successful', [
                'user_id' => $account->id,
                'user_name' => $account->name,
                'new_session_id' => session()->getId()
            ]);

            return redirect('/accounts/home')->with('success', 'ログインしました');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->except('password')
            ]);

            return redirect()->route('auth.index')
                ->withErrors($e->errors())
                ->withInput($request->except('password'));

        } catch (\Exception $e) {
            Log::error('Login error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('auth.index', ['error_id' => 99])
                ->with('error', 'システムエラーが発生しました');
        }
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
