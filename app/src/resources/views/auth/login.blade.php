{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'ログイン')
@section('description', 'ユーザーログインページ')

@section('content')
    <div class="container">
        <div class="login-wrapper">
            <h2>管理画面ログイン</h2>

            {{-- デバッグ情報（開発時のみ表示） --}}
            @if(config('app.debug'))
                <div class="debug-info">
                    <p><strong>デバッグ情報:</strong></p>
                    <p>セッションID: <code>{{ session()->getId() }}</code></p>
                    <p>CSRFトークン: <code>{{ csrf_token() }}</code></p>
                    <p>セッション開始: {{ session()->isStarted() ? 'はい' : 'いいえ' }}</p>
                    <p>現在時刻: {{ now()->format('Y-m-d H:i:s') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="name">名前：</label>
                    <input id="name"
                           name="name"
                           type="text"
                           autocomplete="username"
                           value="{{ old('name') }}"
                           required
                           class="form-input">
                </div>

                <div class="form-group">
                    <label for="password">パスワード：</label>
                    <input id="password"
                           name="password"
                           type="password"
                           autocomplete="current-password"
                           required
                           class="form-input">
                </div>

                <div class="form-group">
                    <input name="submit"
                           type="submit"
                           value="ログイン"
                           class="submit-btn">
                </div>
            </form>

            {{-- エラーメッセージ表示 --}}
            @if (isset($error_id))
                <div class="error-container">
                    @if ($error_id == 1)
                        <p class="error-message">ユーザー名が存在しません</p>
                    @elseif ($error_id == 2)
                        <p class="error-message">パスワードが違います</p>
                    @else
                        <p class="error-message">ログインエラーが発生しました (エラーID: {{ $error_id }})</p>
                    @endif
                </div>
            @endif

            {{-- セッションメッセージ --}}
            @if (session('error'))
                <div class="error-container">
                    <p class="error-message">{{ session('error') }}</p>
                </div>
            @endif

            @if (session('success'))
                <div class="success-container">
                    <p class="success-message">{{ session('success') }}</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }

        .login-wrapper {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e1e5e9;
        }

        .login-wrapper h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .debug-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .debug-info code {
            background: #e9ecef;
            padding: 2px 4px;
            border-radius: 3px;
            font-family: monospace;
        }

        .login-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background: #0056b3;
        }

        .error-container {
            margin-top: 20px;
            padding: 15px;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
        }

        .success-container {
            margin-top: 20px;
            padding: 15px;
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
        }

        .error-message {
            color: #721c24;
            margin: 0;
        }

        .success-message {
            color: #155724;
            margin: 0;
        }

        .error-list {
            margin: 0;
            padding-left: 20px;
        }

        .error-list li {
            color: #721c24;
        }

        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>

    <script>
        // フォーム送信前のログ
        document.querySelector('.login-form').addEventListener('submit', function (e) {
            console.log('ログイン試行開始:', {
                action: this.action,
                method: this.method,
                name: this.name.value,
                timestamp: new Date().toISOString()
            });
        });

        // ページ読み込み完了時のログ
        document.addEventListener('DOMContentLoaded', function () {
            console.log('ログインページ読み込み完了:', {
                url: window.location.href,
                sessionId: '{{ session()->getId() }}',
                csrfToken: '{{ csrf_token() }}'.substring(0, 10) + '...',
                timestamp: new Date().toISOString()
            });
        });
    </script>
@endsection
