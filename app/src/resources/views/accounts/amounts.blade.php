<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>{{ $title }}</h1>
<form method="get" action="{{ url('amounts') }}">
    @csrf
    <input name="select">
    <input name="submit" type="submit" value="検索">
</form>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
    <tr>
        <th>id</th>
        <th>ユーザー名</th>
        <th>アイテム名</th>
    </tr>
    </thead>
    <tbody>
    @foreach($accounts as $amount)
        <tr>
            <td>{{ $amount->id }}</td>
            <td>{{ $amount->user->name }}</td>
            <td>{{ $amount->item->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<a href="/accounts/home">Homeに戻る</a>
</body>
</html>
