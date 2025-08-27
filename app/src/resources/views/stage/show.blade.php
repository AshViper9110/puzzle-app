{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')

    <h1>ステージ: {{ $stage->name }}</h1>
    <p class="description">{{ $stage->description }}</p>

    <h2>セル一覧</h2>
    <div class="table-container">
        <table class="data-table">
            <thead>
            <tr>
                <th>種類</th>
                <th>X座標</th>
                <th>Y座標</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($stage->cells as $cell)
                <tr>
                    <td>{{ $cell->type }}</td>
                    <td>{{ $cell->x }}</td>
                    <td>{{ $cell->y }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="no-cells">セルが存在しません。</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="action-section">
        <a href="{{ route('stage.index') }}" class="btn btn--primary">
            <i class="fas fa-home"></i>
            <span>ステージ一覧に戻る</span>
        </a>
    </div>
@endsection
