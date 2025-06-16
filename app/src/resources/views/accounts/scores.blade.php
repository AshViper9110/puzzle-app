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
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
    <tr>
        <th>ID</th>
        <th>名前</th>
        <th>スコア</th>
    </tr>
    </thead>
    <tbody>
    @foreach($accounts as $account)
        <tr>
            <td>{{ $account['id'] }}</td>
            <td>{{ $account['name'] }}</td>
            <td>{{ $account['score'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<a href="/accounts/home">Homeに戻る</a>
</body>
</html>
