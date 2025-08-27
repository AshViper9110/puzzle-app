{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <div class="floating-elements">
        <div class="floating-circle"
             style="width: 120px; height: 120px; top: 15%; left: 8%; animation-delay: 0s; background: rgba(255, 215, 0, 0.1);"></div>
        <div class="floating-circle"
             style="width: 180px; height: 180px; top: 55%; right: 5%; animation-delay: 2s; background: rgba(138, 43, 226, 0.1);"></div>
        <div class="floating-circle"
             style="width: 90px; height: 90px; bottom: 25%; left: 15%; animation-delay: 4s; background: rgba(255, 69, 0, 0.1);"></div>
    </div>

    <div class="container">
        <!-- ヘッダーセクション -->
        <div class="header">
            <h1 class="main-title">
                <i class="fas fa-users title-icon"></i>
                {{ $title }}
            </h1>
            <p class="page-subtitle">プレイヤー統計とゲームデータ管理</p>
        </div>

        <!-- 統計情報カード -->
        <div class="nav-grid" style="margin-bottom: 40px;">
            <div class="nav-item nav-item--primary">
                <i class="nav-icon fas fa-users"></i>
                <div class="nav-content">
                    <div class="nav-title player-count">{{ count($accounts) }}</div>
                    <div class="nav-description">総プレイヤー数</div>
                </div>
            </div>
            <div class="nav-item nav-item--success">
                <i class="nav-icon fas fa-coins"></i>
                <div class="nav-content">
                    <div
                        class="nav-title total-money">{{ number_format($accounts->sum(function($account) { return $account->detail->money ?? 0; })) }}</div>
                    <div class="nav-description">総所持金</div>
                </div>
            </div>
            <div class="nav-item nav-item--warning">
                <i class="nav-icon fas fa-star"></i>
                <div class="nav-content">
                    <div class="nav-title avg-level">{{ round($accounts->avg('level') ?? 0, 1) }}</div>
                    <div class="nav-description">平均レベル</div>
                </div>
            </div>
            <div class="nav-item nav-item--purple">
                <i class="nav-icon fas fa-fist-raised"></i>
                <div class="nav-content">
                    <div
                        class="nav-title max-power">{{ number_format($accounts->max(function($account) { return $account->detail->power ?? 0; })) }}</div>
                    <div class="nav-description">最高戦闘力</div>
                </div>
            </div>
        </div>

        <!-- 検索セクション -->
        <div class="search-section">
            <form method="post" action="{{ url('doLogin') }}" class="search-form">
                @csrf
                <input name="select" class="search-input" placeholder="🔍 プレイヤー名・レベルで検索...">
                <button name="submit" type="submit" class="btn btn--primary">
                    <i class="fas fa-search"></i>
                    <span>検索</span>
                </button>
            </form>
        </div>

        <!-- プレイヤーデータテーブル -->
        <div class="table-container">
            <table class="data-table">
                <thead>
                <tr>
                    <th><i class="fas fa-hashtag"></i> ID</th>
                    <th><i class="fas fa-user-ninja"></i> プレイヤー名</th>
                    <th><i class="fas fa-level-up-alt"></i> レベル</th>
                    <th><i class="fas fa-chart-line"></i> 経験値</th>
                    <th><i class="fas fa-coins"></i> 所持金</th>
                    <th><i class="fas fa-fist-raised"></i> 戦闘力</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts as $account)
                    <tr data-player-id="{{ $account['id'] }}" class="player-row">
                        <td class="id-cell">#{{ $account['id'] }}</td>
                        <td class="name-cell">
                            <div class="player-info">
                                <i class="fas fa-user-circle player-avatar"
                                   style="color: {{ $account['level'] >= 50 ? 'var(--warning-color)' : ($account['level'] >= 25 ? 'var(--info-color)' : 'var(--success-color)') }};"></i>
                                <span class="player-name">{{ $account['name'] }}</span>
                            </div>
                        </td>
                        <td class="level-cell">
                            <div
                                class="level-badge level-{{ $account['level'] >= 50 ? 'high' : ($account['level'] >= 25 ? 'medium' : 'low') }}">
                                <i class="fas fa-star"></i>
                                <span>Lv.{{ $account['level'] }}</span>
                            </div>
                        </td>
                        <td class="exp-cell">
                            <div class="exp-container">
                                <span class="exp-value">{{ number_format($account['exp']) }}</span>
                                <div class="exp-bar">
                                    <div class="exp-progress"
                                         style="width: {{ min(($account['exp'] % 1000) / 10, 100) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="money-cell">
                            <div class="money-display">
                                <i class="fas fa-coins" style="color: var(--warning-color);"></i>
                                <span>{{ number_format($account->detail->money ?? 0) }}</span>
                            </div>
                        </td>
                        <td class="power-cell">
                            <div
                                class="power-display power-{{ $account->detail->power >= 1000 ? 'legendary' : ($account->detail->power >= 500 ? 'epic' : 'normal') }}">
                                <i class="fas fa-fire"></i>
                                <span>{{ number_format($account->detail->power ?? 0) }}</span>
                            </div>
                        </td>
                    </tr>
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
    <script>
        // 検索フォームのエンターキー対応
        document.querySelector('.search-input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });

        // プレイヤー行のクリックエフェクト
        document.querySelectorAll('.player-row').forEach(row => {
            row.addEventListener('click', function () {
                const playerId = this.getAttribute('data-player-id');
                console.log('Selected player ID:', playerId);

                // クリック時のエフェクト
                this.style.background = 'rgba(186, 104, 200, 0.2)';
                this.style.transform = 'scale(1.02)';
                this.style.boxShadow = '0 0 20px rgba(186, 104, 200, 0.4)';

                setTimeout(() => {
                    this.style.background = '';
                    this.style.transform = '';
                    this.style.boxShadow = '';
                }, 400);
            });
        });

        // 統計カウンターアニメーション
        function animateCounters() {
            const counters = [
                {element: '.player-count', target: {{ count($accounts) }}},
                {
                    element: '.total-money',
                    target: {{ $accounts->sum(function($account) { return $account->detail->money ?? 0; }) }}
                },
                {element: '.avg-level', target: {{ round($accounts->avg('level') ?? 0, 1) }}, isDecimal: true},
                {
                    element: '.max-power',
                    target: {{ $accounts->max(function($account) { return $account->detail->power ?? 0; }) }}
                }
            ];

            counters.forEach((counter, index) => {
                const element = document.querySelector(counter.element);
                if (!element) return;

                let current = 0;
                const increment = counter.target / 50;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= counter.target) {
                        current = counter.target;
                        clearInterval(timer);
                    }

                    if (counter.isDecimal) {
                        element.textContent = current.toFixed(1);
                    } else {
                        element.textContent = Math.floor(current).toLocaleString();
                    }
                }, 30 + index * 20);
            });
        }

        // 経験値バーのアニメーション
        function animateExpBars() {
            document.querySelectorAll('.exp-progress').forEach((bar, index) => {
                const width = bar.style.width;
                bar.style.width = '0%';

                setTimeout(() => {
                    bar.style.width = width;
                }, 500 + index * 100);
            });
        }

        // 検索結果のハイライト
        function highlightSearchTerm() {
            const searchTerm = document.querySelector('.search-input').value.toLowerCase();
            if (searchTerm) {
                const cells = document.querySelectorAll('.name-cell, .level-cell');
                cells.forEach(cell => {
                    const text = cell.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        cell.style.background = 'rgba(255, 235, 59, 0.3)';
                        cell.style.borderRadius = '8px';
                        cell.style.fontWeight = '700';
                        cell.style.boxShadow = '0 0 10px rgba(255, 235, 59, 0.5)';
                    }
                });
            }
        }

        // リアルタイム検索ハイライト
        document.querySelector('.search-input').addEventListener('input', function () {
            // 既存のハイライトをクリア
            document.querySelectorAll('.name-cell, .level-cell').forEach(cell => {
                cell.style.background = '';
                cell.style.borderRadius = '';
                cell.style.fontWeight = '';
                cell.style.boxShadow = '';
            });

            // 新しいハイライトを適用
            highlightSearchTerm();
        });

        // ページ読み込み時のアニメーション
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(animateCounters, 300);
            setTimeout(animateExpBars, 800);
            highlightSearchTerm();
        });

        // 戦闘力セルの特別エフェクト
        document.querySelectorAll('.power-legendary').forEach(cell => {
            cell.addEventListener('mouseenter', function () {
                this.style.transform = 'scale(1.1)';
                this.style.filter = 'brightness(1.2)';
            });

            cell.addEventListener('mouseleave', function () {
                this.style.transform = '';
                this.style.filter = '';
            });
        });
    </script>
@endsection
