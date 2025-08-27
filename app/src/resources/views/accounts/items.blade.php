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
        <!-- ヘッダーセクション -->
        <div class="header">
            <h1 class="main-title">
                <i class="fas fa-box title-icon"></i>
                {{ $title }}
            </h1>
            <p class="page-subtitle">データ管理とストア操作のダッシュボード</p>
        </div>

        <!-- 統計情報とアクション -->
        <div class="nav-grid" style="margin-bottom: 40px;">
            <div class="nav-item nav-item--primary">
                <i class="nav-icon fas fa-database"></i>
                <div class="nav-content">
                    <div class="nav-title">{{ count($accounts) }}</div>
                    <div class="nav-description">総アカウント数</div>
                </div>
            </div>
            <div class="nav-item nav-item--success" style="cursor: pointer;"
                 onclick="location.href='{{ route('store.create') }}'">
                <i class="nav-icon fas fa-plus-circle"></i>
                <div class="nav-content">
                    <div class="nav-title">新規作成</div>
                    <div class="nav-description">新しいアカウントを追加</div>
                </div>
            </div>
            <div class="nav-item nav-item--info">
                <i class="nav-icon fas fa-chart-line"></i>
                <div class="nav-content">
                    <div class="nav-title">管理中</div>
                    <div class="nav-description">アクティブなストア</div>
                </div>
            </div>
        </div>

        <!-- 検索セクション -->
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

        <!-- データテーブル -->
        <div class="table-container">
            <table class="data-table">
                <thead>
                <tr>
                    <th><i class="fas fa-hashtag"></i> ID</th>
                    <th><i class="fas fa-user"></i> 名前</th>
                    <th><i class="fas fa-tag"></i> 種類</th>
                    <th><i class="fas fa-cogs"></i> 操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts as $account)
                    <tr data-account-id="{{ $account['id'] }}">
                        <td class="id-cell">#{{ $account['id'] }}</td>
                        <td class="name-cell">
                            <i class="fas fa-user-circle" style="color: var(--success-color); margin-right: 8px;"></i>
                            {{ $account['name'] }}
                        </td>
                        <td class="type-cell">
                            <span class="type-badge type-badge--{{ strtolower($account['type']) }}">
                                <i class="fas fa-tag"></i>
                                {{ $account['type'] }}
                            </span>
                        </td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="{{ route('store.edit', ['id' => $account['id']]) }}"
                                   class="btn btn--small btn--warning" title="編集">
                                    <i class="fas fa-edit"></i>
                                    <span>更新</span>
                                </a>
                                <a href="{{ route('store.delete', ['name' => $account['name']]) }}"
                                   class="btn btn--small btn--danger"
                                   title="削除"
                                   onclick="return confirm('本当に「{{ $account['name'] }}」を削除しますか？')">
                                    <i class="fas fa-trash"></i>
                                    <span>削除</span>
                                </a>
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

        // テーブル行のクリックエフェクト
        document.querySelectorAll('.data-table tbody tr').forEach(row => {
            row.addEventListener('click', function (e) {
                // ボタンクリック時は行のクリックイベントを発火させない
                if (e.target.closest('.btn')) return;

                this.style.background = 'rgba(79, 195, 247, 0.2)';
                this.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    this.style.background = '';
                    this.style.transform = '';
                }, 300);
            });
        });

        // nav-itemのクリック機能
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('mouseenter', function () {
                if (this.onclick) {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                }
            });

            item.addEventListener('mouseleave', function () {
                this.style.transform = '';
            });
        });

        // 検索結果のハイライト
        function highlightSearchTerm() {
            const searchTerm = document.querySelector('.search-input').value.toLowerCase();
            if (searchTerm) {
                const cells = document.querySelectorAll('.name-cell, .type-cell, .id-cell');
                cells.forEach(cell => {
                    const text = cell.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        cell.style.background = 'rgba(255, 235, 59, 0.2)';
                        cell.style.fontWeight = '700';
                        cell.style.borderRadius = '8px';
                        cell.style.padding = '8px 12px';
                    }
                });
            }
        }

        // リアルタイム検索ハイライト
        document.querySelector('.search-input').addEventListener('input', function () {
            // 既存のハイライトをクリア
            document.querySelectorAll('.name-cell, .type-cell, .id-cell').forEach(cell => {
                cell.style.background = '';
                cell.style.fontWeight = '';
                cell.style.borderRadius = '';
                cell.style.padding = '';
            });

            // 新しいハイライトを適用
            highlightSearchTerm();
        });

        // ページ読み込み時に検索ハイライト実行
        document.addEventListener('DOMContentLoaded', highlightSearchTerm);

        // 削除ボタンのダブルクリック防止
        document.querySelectorAll('.btn--danger').forEach(btn => {
            btn.addEventListener('click', function (e) {
                if (this.classList.contains('processing')) {
                    e.preventDefault();
                    return false;
                }

                this.classList.add('processing');
                setTimeout(() => {
                    this.classList.remove('processing');
                }, 3000);
            });
        });
    </script>
@endsection
