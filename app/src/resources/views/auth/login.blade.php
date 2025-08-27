{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <div class="container">
        <form method="post" action="{{ route('login') }}">
            @csrf
            <label for="name">名前　:</label>
            <input id="name" name="name" type="text" autocomplete="username"><br>
            <label for="password">パスワード:</label>
            <input id="password" name="password" type="password" autocomplete="current-password"><br>
            <input name="submit" type="submit" value="ログイン">
        </form>

        @if ($error_id == 1)
            <p class="error-message">名前かパスワードが入力されていません</p>
        @elseif ($error_id == 2)
            <p class="error-message">名前かパスワードが違います</p>
        @endif

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
