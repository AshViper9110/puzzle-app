{{-- resources/views/dashboard/home.blade.php --}}
@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のメインダッシュボード')

@section('content')
    <h1>Index</h1>
    <form method="post" action="{{url('auth/login')}}">
        @csrf
        <input name="select">
        <input name="submit" type="submit" value="検索">
    </form>
    <div class="table-container">
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>パスワード</th>
            </tr>
            </thead>
            <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $account['id'] }}</td>
                    <td>{{ $account['name'] }}</td>
                    <td>{{ $account['password'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <form method="post" action="{{url('auth/logout')}}">
        @csrf
        <input name="submit" type="submit" value="logout">
    </form>
@endsection


