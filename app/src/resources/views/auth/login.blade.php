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
<form method="post" action="{{url('auth/login')}}">
    @csrf
    名前　 :<input name="name" type="text"><br>
    パスワード:<input name="password" type="text"><br>
    <input name="submit" type="submit">
</form>
@if ($error_id == 1)
    <p>nameかpasswordがありません</p>
@elseif($error_id == 2)
    <p>nameかpasswordが違います</p>
@endif
@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif
</body>
</html>
