{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <h1>アイテム削除</h1>

    @if ($done)
        <p>「{{ $name }}」を削除しました。</p>
    @else
        <p>「{{ $name }}」を本当に削除しますか？</p>
        <form action="{{ url('store/delete/' . $name) }}" method="POST">
            @csrf
            <button type="submit">はい、削除します</button>
        </form>
    @endif

    <a href="{{ url('/accounts/items') }}">戻る</a>
@endsection
