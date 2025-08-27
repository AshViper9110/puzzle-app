{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <h1>アイテム編集</h1>

    <form action="{{ url('store/update/' . $item->id) }}" method="POST">
        @csrf
        <div>
            <label>アイテム名:</label>
            <input type="text" name="name" value="{{ old('name', $item->name) }}" required>
        </div>
        <div>
            <label>タイプ:</label>
            <input type="text" name="type" value="{{ old('type', $item->type) }}" required>
        </div>
        <div>
            <button type="submit">更新</button>
        </div>
    </form>

    <a href="{{ url('/accounts/items') }}">戻る</a>
@endsection
