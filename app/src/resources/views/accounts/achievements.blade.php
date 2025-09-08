{{-- resources/views/accounts/achievements.blade.php --}}
@extends('layouts.app')

@section('title', $title)
@section('description', 'ユーザーとアチーブメントの管理画面')

@section('content')
    <div class="container">
        <div class="header">
            <h1 class="main-title">
                <i class="fas fa-trophy title-icon"></i>
                {{ $title }}
            </h1>
            <p class="page-subtitle">ユーザーが持っているアチーブメント一覧</p>
        </div>

        <!-- 検索 -->
        <div class="search-section">
            <form method="get" action="{{ url('achievements') }}" class="search-form">
                @csrf
                <input
                    name="select"
                    class="search-input"
                    placeholder="🔍 ユーザー名・アチーブメント内容で検索..."
                    value="{{ request('select') }}"
                >
                <button type="submit" class="btn btn--primary">
                    <i class="fas fa-search"></i>
                    <span>検索</span>
                </button>
            </form>
        </div>

        <!-- データテーブル -->
        <div class="table-container">
            <table class="data-table">
                <thead>
                <tr>
                    <th><i class="fas fa-user"></i> ユーザー名</th>
                    <th><i class="fas fa-medal"></i> アチーブメント</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    @if($user->achievements->isNotEmpty())
                        @foreach($user->achievements as $achievement)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $achievement->content }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                                    <span class="empty-cell">
                                        <i class="fas fa-ban" style="margin-right: 8px;"></i>
                                        アチーブメントなし
                                    </span>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- アクションセクション -->
        <div class="action-section">
            <a href="/accounts/home" class="btn btn--primary">
                <i class="fas fa-home"></i>
                <span>Homeに戻る</span>
            </a>
        </div>
    </div>
@endsection
