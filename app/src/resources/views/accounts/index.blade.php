{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <div class="container">
        <div class="header">
            <h1 class="main-title">
                <i class="fas fa-chart-bar title-icon"></i>
                Index
            </h1>
            <p class="page-subtitle">データ管理とストア操作のダッシュボード</p>
        </div>

        <div class="search-section">
            <form method="post" action="{{ url('doLogin') }}" class="search-form">
                @csrf
                <input name="select" class="search-input" placeholder="🔍 ID、名前、種類で検索...">
                <button name="submit" type="submit" class="btn btn--primary">
                    <i class="fas fa-search"></i>
                    <span>検索</span>
                </button>
            </form>
        </div>
        {{$accounts->links()}}
        <div class="table-container">
            <table class="data-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>パスワード</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts as $account)
                    <tr>
                        <td>{{ $account['id'] }}</td>
                        <td>{{ $account['name'] }}</td>
                        <td>{{ $account['password'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="action-section">
            <a href="/accounts/home" class="btn btn--primary">
                <i class="fas fa-home"></i>
                <span>Homeに戻る</span>
            </a>
        </div>
    </div>
@endsection
