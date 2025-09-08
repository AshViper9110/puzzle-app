<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // デバッグログ
        \Log::info('AuthMiddleware check', [
            'url' => $request->fullUrl(),
            'session_id' => session()->getId(),
            'login_exists' => Session::has('login'),
            'login_value' => Session::get('login', 'not_set'),
            'user_id' => Session::get('user_id', 'not_set'),
            'user_name' => Session::get('user_name', 'not_set'),
            'all_session_keys' => array_keys(Session::all())
        ]);

        // セッションチェックの修正
        if (!Session::has('login') || !Session::get('login')) {
            \Log::info('Authentication failed - redirecting to login');
            return redirect()->route('auth.index')->with('error', '認証が必要です');
        }

        \Log::info('Authentication passed', [
            'user_id' => Session::get('user_id'),
            'user_name' => Session::get('user_name')
        ]);

        return $next($request);
    }
}
