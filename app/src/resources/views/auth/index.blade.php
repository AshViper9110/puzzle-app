<html lang="ja">
<body>
<h1>Index</h1>
<form method="post" action="{{url('auth/login')}}">
    @csrf
    <input name="select">
    <input name="submit" type="submit" value="検索">
</form>
<table border="1" cellpadding="8" cellspacing="0">
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
<form method="post" action="{{url('auth/logout')}}">
    @csrf
    <input name="submit" type="submit" value="logout">
</form>
</body>
</html>


