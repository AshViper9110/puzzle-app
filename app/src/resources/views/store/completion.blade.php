@extends('layouts.app')

@section('body')
    <h1>作成完了</h1>
    <p>「{{ $name }}」を作成しました。</p>
    <a href="{{ url('/accounts/items') }}">アイテム一覧へ</a>
@endsection
