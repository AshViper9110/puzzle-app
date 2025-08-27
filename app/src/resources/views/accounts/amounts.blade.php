{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <div class="floating-elements">
        <div class="floating-circle"
             style="width: 100px; height: 100px; top: 10%; left: 10%; animation-delay: 0s;"></div>
        <div class="floating-circle"
             style="width: 150px; height: 150px; top: 60%; right: 10%; animation-delay: 2s;"></div>
        <div class="floating-circle"
             style="width: 80px; height: 80px; bottom: 20%; left: 20%; animation-delay: 4s;"></div>
    </div>

    <div class="container">
        <div class="header">
            <h1 class="main-title">
                <i class="fas fa-coins title-icon"></i>
                {{ $title }}
            </h1>
            <p class="page-subtitle">金額・収益データの管理画面</p>
        </div>

        <!-- 統計情報をナビゲーションカード風に表示 -->
        <div class="nav-grid" style="margin-bottom: 40px;">
            <div class="nav-item nav-item--primary">
                <i class="nav-icon fas fa-database"></i>
                <div class="nav-content">
                    <div class="nav-title stat-number">{{ count($amounts) }}</div>
                    <div class="nav-description">総件数</div>
                </div>
            </div>
            <div class="nav-item nav-item--success">
                <i class="nav-icon fas fa-user-check"></i>
                <div class="nav-content">
                    <div class="nav-title stat-number">{{ $amounts->where('user')->count() }}</div>
                    <div class="nav-description">ユーザー紐付き</div>
                </div>
            </div>
            <div class="nav-item nav-item--info">
                <i class="nav-icon fas fa-box-open"></i>
                <div class="nav-content">
                    <div class="nav-title stat-number">{{ $amounts->where('item')->count() }}</div>
                    <div class="nav-description">アイテム紐付き</div>
                </div>
            </div>
        </div>

        <!-- 検索セクション -->
        <div class="search-section">
            <form method="get" action="{{ url('amounts') }}" class="search-form">
                @csrf
                <input
                    name="select"
                    class="search-input"
                    placeholder="🔍 ユーザー名・アイテム名で検索..."
                    value="{{ request('select') }}"
                >
                <button name="submit" type="submit" class="btn btn--primary">
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
                    <th><i class="fas fa-hashtag"></i> ID</th>
                    <th><i class="fas fa-user"></i> ユーザー名</th>
                    <th><i class="fas fa-box"></i> アイテム名</th>
                </tr>
                </thead>
                <tbody>
                @foreach($amounts as $amount)
                    <tr>
                        <td class="id-cell">#{{ $amount->id }}</td>
                        <td class="user-cell">
                            @if($amount->user)
                                <i class="fas fa-user-circle" style="color: #48bb78; margin-right: 8px;"></i>
                                {{ $amount->user->name }}
                            @else
                                <span class="empty-cell">
                                    <i class="fas fa-user-slash" style="margin-right: 8px;"></i>
                                    データなし
                                </span>
                            @endif
                        </td>
                        <td class="item-cell">
                            @if($amount->item)
                                <i class="fas fa-cube" style="color: #4299e1; margin-right: 8px;"></i>
                                {{ $amount->item->name }}
                            @else
                                <span class="empty-cell">
                                    <i class="fas fa-ban" style="margin-right: 8px;"></i>
                                    データなし
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- アクションセクション（components.cssのスタイルを使用） -->
        <div class="action-section">
            <a href="/accounts/home" class="btn btn--primary">
                <i class="fas fa-home"></i>
                <span>ホームに戻る</span>
            </a>
        </div>
        <script>
            // 検索フォームのエンターキー対応
            document.querySelector('.search-input').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    this.closest('form').submit();
                }
            });

            // テーブル行のクリックエフェクト（components.cssのホバー効果と統合）
            document.querySelectorAll('.data-table tbody tr').forEach(row => {
                row.addEventListener('click', function () {
                    this.style.background = 'rgba(79, 195, 247, 0.2)';
                    this.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        this.style.background = '';
                        this.style.transform = '';
                    }, 300);
                });
            });

            // 統計情報のアニメーション（nav-itemとして表示されているため改良）
            function animateStats() {
                const statNumbers = document.querySelectorAll('.stat-number');
                statNumbers.forEach((stat, index) => {
                    const finalValue = parseInt(stat.textContent);
                    let currentValue = 0;
                    const increment = Math.ceil(finalValue / 40);

                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            currentValue = finalValue;
                            clearInterval(timer);
                        }
                        stat.textContent = currentValue;
                    }, 60 + index * 30);
                });
            }

            // ページ読み込み時にアニメーション実行
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(animateStats, 500);
            });

            // 検索結果のハイライト
            function highlightSearchTerm() {
                const searchTerm = document.querySelector('.search-input').value.toLowerCase();
                if (searchTerm) {
                    const cells = document.querySelectorAll('.user-cell, .item-cell');
                    cells.forEach(cell => {
                        const text = cell.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            cell.style.background = 'rgba(255, 235, 59, 0.3)';
                            cell.style.fontWeight = '700';
                            cell.style.borderRadius = '8px';
                            cell.style.padding = '8px 12px';
                        }
                    });
                }
            }

            // ページ読み込み時に検索ハイライト実行
            document.addEventListener('DOMContentLoaded', highlightSearchTerm);

            // components.cssのナビゲーションアイテムに合わせたインタラクション
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });

                item.addEventListener('mouseleave', function () {
                    this.style.transform = '';
                });
            });
        </script>
@endsection
