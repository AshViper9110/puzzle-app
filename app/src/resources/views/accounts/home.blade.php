<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メインページ</title>
</head>
<body>
<h1>ページ選択</h1>
<ul>
    <li><a href="/accounts/users">Usersへ</a></li>
    <li><a href="/accounts/items">Itemsへ</a></li>
    <li><a href="/accounts/amounts">Amountsへ</a></li>
    <li><a href="/accounts/index">Indexへ</a></li>
</ul>
<form method="post" action="{{url('auth/logout')}}">
    @csrf
    <input name="submit" type="submit" value="logout">
</form>
</body>
</html>
