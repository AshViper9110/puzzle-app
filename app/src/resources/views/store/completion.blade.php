{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <h1>作成完了</h1>
    <p>「{{ $name }}」を作成しました。</p>
    <a href="{{ url('/accounts/items') }}">アイテム一覧へ</a>
@endsection
