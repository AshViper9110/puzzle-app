<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>ログインフォーム</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f9f9f9;
        }

        form {
            max-width: 320px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: inline-block;
            width: 80px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="text"], input[type="password"] {
            width: calc(100% - 90px);
            padding: 6px 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: #e74c3c;
            margin-top: 15px;
            font-weight: bold;
            text-align: center;
        }

        ul {
            color: #e74c3c;
            list-style-type: none;
            padding-left: 0;
            text-align: left;
            max-width: 320px;
            margin: 10px auto 0 auto;
        }
    </style>
</head>
<body>
<form method="post" action="{{ route('login') }}">
    @csrf
    <label for="name">名前　:</label>
    <input id="name" name="name" type="text" autocomplete="username"><br>
    <label for="password">パスワード:</label>
    <input id="password" name="password" type="password" autocomplete="current-password"><br>
    <input name="submit" type="submit" value="ログイン">
</form>

@if ($error_id == 1)
    <p class="error-message">名前かパスワードが入力されていません</p>
@elseif ($error_id == 2)
    <p class="error-message">名前かパスワードが違います</p>
@endif

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
</body>
</html>
