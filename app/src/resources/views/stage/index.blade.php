{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <div class="container">
        <!-- ヘッダーセクション -->
        <div class="header">
            <h1 class="main-title">
                <i class="fas fa-layer-group title-icon"></i>
                StageList
            </h1>
            <p class="page-subtitle">ステージ統計とステージデータ管理</p>
        </div>

        <div>
            {{-- JSONアップロードフォーム --}}
            <form action="{{ route('stage.upload') }}" method="POST" enctype="multipart/form-data"
                  style="margin-bottom: 2em; font-family: 'Segoe UI', sans-serif;">
                @csrf
                <label for="json_file"
                       style="font-weight: 600; margin-right: 0.5em;">ステージJSONファイルを選択：</label>
                <input type="file" id="json_file" name="json_file" accept=".json" required
                       style="padding: 0.3em; border: 1px solid #ccc; border-radius: 4px;">
                <button type="submit"
                        style="padding: 0.4em 1em; margin-left: 1em; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;
                   transition: background-color 0.3s;">
                    アップロード
                </button>
            </form>

            <div class="action-section">
                <a href="/stage/create" class="btn btn--primary">
                    <i class="fas fa-home"></i>
                    <span>ステージを作成</span>
                </a>
            </div>
        </div>
        {{-- メッセージ表示 --}}
        @if(session('success'))
            <p style="color: green; font-family: 'Segoe UI', sans-serif; margin-bottom: 1em;">
                {{ session('success') }}
            </p>
        @endif
        @if(session('error'))
            <p style="color: red; font-family: 'Segoe UI', sans-serif; margin-bottom: 1em;">
                {{ session('error') }}
            </p>
        @endif

        {{-- 既存のステージ一覧 --}}
        @if ($stages->isEmpty())
            <p class="no-stage" style="font-style: italic; color: #666; font-family: 'Segoe UI', sans-serif;">
                ステージが存在しません。
            </p>
        @else
            <div class="table-container">
                <table class="data-table">
                    <thead style="background-color: #e3eaf2;">
                    <tr>
                        <th style="padding: 0.75em 1em; border-bottom: 1px solid #ccc; text-align: left;">ID</th>
                        <th style="padding: 0.75em 1em; border-bottom: 1px solid #ccc; text-align: left;">ステージ名
                        </th>
                        <th style="padding: 0.75em 1em; border-bottom: 1px solid #ccc; text-align: left;">詳細</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($stages as $stage)
                        <tr style="border-bottom: 1px solid #eee; cursor: default;"
                            onmouseover="this.style.backgroundColor='#f1f1f115';"
                            onmouseout="this.style.backgroundColor='transparent';">
                            <td style="padding: 0.75em 1em;">{{ $stage->id }}</td>
                            <td style="padding: 0.75em 1em;">{{ $stage->name ?? '（名前なし）' }}</td>
                            <td style="padding: 0.75em 1em;">
                                <a href="{{ route('stage.show', ['id' => $stage->id]) }}"
                                   style="color: #007bff; text-decoration: none;"
                                   onmouseover="this.style.textDecoration='underline';"
                                   onmouseout="this.style.textDecoration='none';">
                                    表示
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="action-section">
            <a href="/accounts/home" class="btn btn--primary">
                <i class="fas fa-home"></i>
                <span>ホームに戻る</span>
            </a>
        </div>
@endsection
