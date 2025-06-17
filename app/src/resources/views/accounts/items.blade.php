<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<h1>{{$title}}</h1>
<body>
<form method="post" action="{{url('doLogin')}}">
    @csrf
    <input name="select">
    <input name="submit" type="submit" value="検索">
</form>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        <th>名前</th>
        <th>種類</th>
    </tr>
    </thead>
    <tbody>
    @foreach($accounts as $account)
        <tr>
            <td>{{ $account['id'] }}</td>
            <td>{{ $account['name'] }}</td>
            <td>{{ $account['type'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<a href="/accounts/home">Homeに戻る</a>
</body>
</html>
