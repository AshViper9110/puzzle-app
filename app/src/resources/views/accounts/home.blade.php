{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <div class="container">
        <div class="header">
            <h1 class="main-title">ダッシュボード</h1>
            <p class="subtitle">管理画面へようこそ。下記からページを選択してください。</p>
        </div>

        <div class="nav-grid">
            <a href="{{ route('accounts.users') }}" class="nav-item nav-item--primary" data-tooltip="ユーザー管理">
                <div class="nav-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="nav-content">
                    <div class="nav-title">Users</div>
                    <div class="nav-description">ユーザー管理画面<br>アカウント情報の確認・編集</div>
                </div>
            </a>

            <a href="{{ route('accounts.items') }}" class="nav-item nav-item--success" data-tooltip="アイテム管理">
                <div class="nav-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="nav-content">
                    <div class="nav-title">Items</div>
                    <div class="nav-description">アイテム管理画面<br>商品・アイテムの管理</div>
                </div>
            </a>

            <a href="{{ route('accounts.amounts') }}" class="nav-item nav-item--warning" data-tooltip="金額管理">
                <div class="nav-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="nav-content">
                    <div class="nav-title">Amounts</div>
                    <div class="nav-description">金額管理画面<br>売上・収益の確認</div>
                </div>
            </a>

            <a href="{{ route('accounts.index') }}" class="nav-item nav-item--info" data-tooltip="統計情報">
                <div class="nav-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="nav-content">
                    <div class="nav-title">Index</div>
                    <div class="nav-description">インデックス画面<br>全体の統計・概要</div>
                </div>
            </a>

            <a href="{{ route('stage.index') }}" class="nav-item nav-item--purple" data-tooltip="ステージ管理">
                <div class="nav-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="nav-content">
                    <div class="nav-title">Stage List</div>
                    <div class="nav-description">ステージ管理画面<br>ステージ情報の管理</div>
                </div>
            </a>
        </div>

        <div class="action-section">
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn--danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>ログアウト</span>
                </button>
            </form>
        </div>
    </div>
@endsection
