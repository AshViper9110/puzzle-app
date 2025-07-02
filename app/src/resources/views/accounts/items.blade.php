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
            background-color: #f5f5f5;
            color: #333;
            padding: 30px;
            margin: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
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
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .button {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 4px;
            font-size: 14px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-edit {
            background-color: #27ae60;
            color: white;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }

        .btn-edit:hover {
            background-color: #219150;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        a[href="/accounts/home"] {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-weight: bold;
            text-decoration: none;
            color: #3498db;
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

<a href="{{ route('store.create') }}" class="button btn-edit">新規作成</a>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>名前</th>
        <th>種類</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($accounts as $account)
        <tr>
            <td>{{ $account['id'] }}</td>
            <td>{{ $account['name'] }}</td>
            <td>{{ $account['type'] }}</td>
            <td>
                <a href="{{ route('store.edit', ['id' => $account['id']]) }}" class="button btn-edit">更新</a>
                <a href="{{ route('store.delete', ['name' => $account['name']]) }}" class="button btn-delete">削除</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<a href="/accounts/home">Homeに戻る</a>
</body>
</html>
