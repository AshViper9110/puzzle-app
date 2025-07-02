<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7f9;
            padding: 40px;
            text-align: center;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
        }

        form {
            margin-bottom: 30px;
        }

        input[type="text"], input[name="select"] {
            padding: 10px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 10px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
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

<form method="get" action="{{ url('amounts') }}">
    @csrf
    <input name="select" placeholder="検索キーワード">
    <input name="submit" type="submit" value="検索">
</form>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>ユーザー名</th>
        <th>アイテム名</th>
    </tr>
    </thead>
    <tbody>
    @foreach($amounts as $amount)
        <tr>
            <td>{{ $amount->id }}</td>
            <td>{{ $amount->user ? $amount->user->name : '—' }}</td>
            <td>{{ $amount->item ? $amount->item->name : '—' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<a href="/accounts/home">Homeに戻る</a>
</body>
</html>
