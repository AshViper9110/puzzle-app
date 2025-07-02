@extends('layouts.app')
@section('title','Home')
@section('body')
    <h1>ページ選択</h1>

    <ul>
        <li><a href="/accounts/users">Usersへ</a></li>
        <li><a href="/accounts/items">Itemsへ</a></li>
        <li><a href="/accounts/amounts">Amountsへ</a></li>
        <li><a href="/accounts/index">Indexへ</a></li>
        <li><a href="{{ route('stage.index') }}">stageListへ</a></li>
    </ul>

    <form method="post" action="{{ route('logout') }}">
        @csrf
        <input name="submit" type="submit" value="ログアウト"/>
    </form>
@endsection
