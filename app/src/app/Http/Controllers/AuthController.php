<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        return view('auth/login', ['error_id' => $request->error_id]);
    }

    public function logout(Request $request)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        return redirect('/auth/index');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:20'],
            'password' => ['required']
        ]);

        $account = Accounts::where('name', $request->name)->first();

        if (!$account) {
            return redirect('/auth/index/1'); // ユーザー名が存在しない
        }

        if (!Hash::check($request->password, $account->password)) {
            return redirect('/auth/index/3'); // パスワードが違う
        }
        return redirect('/accounts/home');
    }
}
