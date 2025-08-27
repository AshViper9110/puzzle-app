{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <h1>アイテム作成</h1>

    <form action="{{ url('store/set') }}" method="POST">
        @csrf
        <div>
            <label>アイテム名:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>タイプ:</label>
            <input type="text" name="type" required>
        </div>
        <div>
            <button type="submit">作成</button>
        </div>
    </form>
@endsection
