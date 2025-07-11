<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 30px;
            margin: 0;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        input[type="text"], input[name="select"] {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        a[href="/accounts/home"] {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-weight: bold;
            text-decoration: none;
            color: #3498db;
        }

        a[href="/accounts/home"]:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
<h1>{{ $title }}</h1>

<form method="post" action="{{ url('doLogin') }}">
    @csrf
    <input name="select" placeholder="検索キーワード">
    <input name="submit" type="submit" value="検索">
</form>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>名前</th>
        <th>レベル</th>
        <th>経験値</th>
        <th>所持金</th>
        <th>戦闘力</th>
    </tr>
    </thead>
    <tbody>
    @foreach($accounts as $account)
        <tr>
            <td>{{ $account['id'] }}</td>
            <td>{{ $account['name'] }}</td>
            <td>{{ $account['level'] }}</td>
            <td>{{ $account['exp'] }}</td>
            <td>{{ $account->detail->money }}</td>
            <td>{{ $account->detail->power }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<a href="/accounts/home">Homeに戻る</a>
</body>
</html>
