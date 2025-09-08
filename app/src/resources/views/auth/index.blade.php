@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <div class="container">
        <h1>ダッシュボード</h1>

        @guest
            {{-- 未認証ユーザー用：ログインフォーム --}}
            <div class="login-section">
                <h2>ログイン</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">名前:</label>
                        <input id="name" name="name" type="text" required autocomplete="username"
                               value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">パスワード:</label>
                        <input id="password" name="password" type="password" required autocomplete="current-password">
                    </div>

                    <button type="submit" class="btn-primary">ログイン</button>
                </form>

                {{-- エラーメッセージ --}}
                @if (isset($error_id))
                    @if ($error_id == 1)
                        <p class="error-message">ユーザー名が存在しません</p>
                    @elseif ($error_id == 2)
                        <p class="error-message">パスワードが違います</p>
                    @endif
                @endif

                @if ($errozrs->any())
                    <ul class="error-message">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

        @else
            {{-- 認証済みユーザー用：ダッシュボードコンテンツ --}}
            <div class="dashboard-header">
                <p>ようこそ、{{ auth()->user()->name }}さん</p>
            </div>

            {{-- アカウント一覧（管理者のみ表示） --}}
            @can('admin')
                @if(isset($accounts) && $accounts->count() > 0)
                    <div class="accounts-section">
                        <h2>アカウント一覧</h2>
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>名前</th>
                                    <th>作成日</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($accounts as $account)
                                    <tr>
                                        <td>{{ $account->id }}</td>
                                        <td>{{ $account->name }}</td>
                                        <td>{{ $account->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('accounts.edit', $account->id) }}"
                                               class="btn-small">編集</a>
                                            {{-- パスワードリセットボタンなど --}}
                                            <form method="POST"
                                                  action="{{ route('accounts.reset-password', $account->id) }}"
                                                  style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn-small btn-warning"
                                                        onclick="return confirm('パスワードをリセットしますか？')">
                                                    パスワードリセット
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endcan

            {{-- ダッシュボードメニュー --}}
            <div class="dashboard-menu">
                <h2>メニュー</h2>
                <ul>
                    <li><a href="{{ route('profile.edit') }}">プロフィール編集</a></li>
                    @can('admin')
                        <li><a href="{{ route('admin.users') }}">ユーザー管理</a></li>
                        <li><a href="{{ route('admin.settings') }}">システム設定</a></li>
                    @endcan
                </ul>
            </div>

            {{-- ログアウトフォーム --}}
            <div class="logout-section">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-secondary">ログアウト</button>
                </form>
            </div>
        @endguest

    </div>

    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            max-width: 300px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-small {
            padding: 5px 10px;
            font-size: 12px;
            text-decoration: none;
            background-color: #28a745;
            color: white;
            border-radius: 3px;
            margin-right: 5px;
        }

        .btn-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }

        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }

        .dashboard-header {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .accounts-section,
        .dashboard-menu {
            margin: 20px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table th,
        .data-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .data-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .dashboard-menu ul {
            list-style-type: none;
            padding: 0;
        }

        .dashboard-menu li {
            margin-bottom: 10px;
        }

        .dashboard-menu a {
            text-decoration: none;
            color: #007bff;
            padding: 10px;
            display: block;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .dashboard-menu a:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection
