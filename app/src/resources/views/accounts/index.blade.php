<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f8fa;
            padding: 40px;
            margin: 0;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        input[type="text"], input[name="select"] {
            padding: 8px;
            width: 220px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f0f0f0;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-weight: bold;
            text-decoration: none;
            color: #3498db;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h1>Index</h1>

<form method="post" action="{{ url('doLogin') }}">
    @csrf
    <input name="select" type="text" placeholder="名前検索">
    <input name="submit" type="submit" value="検索">
</form>
{{$accounts->links()}}
<table>
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

<a href="/accounts/home">Homeに戻る</a>
</body>
</html>
