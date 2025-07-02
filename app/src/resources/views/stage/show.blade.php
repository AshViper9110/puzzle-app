<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8"/>
    <title>ステージ詳細 - {{ $stage->name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2em;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 0.25em;
            color: #222;
        }

        p.description {
            font-size: 1.1em;
            margin-top: 0;
            margin-bottom: 2em;
            color: #555;
        }

        h2 {
            font-size: 1.5em;
            margin-bottom: 0.75em;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 0.75em 1em;
            text-align: center;
        }

        th {
            background-color: #e3eaf2;
            font-weight: 600;
            color: #222;
        }

        tbody tr:hover {
            background-color: #f1f9ff;
        }

        tbody tr td {
            color: #333;
        }

        .no-cells {
            text-align: center;
            font-style: italic;
            color: #888;
            padding: 1em;
        }

        a.back-link {
            display: inline-block;
            margin-top: 2em;
            font-weight: 600;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        a.back-link:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
</head>
<body>

<h1>ステージ: {{ $stage->name }}</h1>
<p class="description">{{ $stage->description }}</p>

<h2>セル一覧</h2>
<table>
    <thead>
    <tr>
        <th>種類</th>
        <th>X座標</th>
        <th>Y座標</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($stage->cells as $cell)
        <tr>
            <td>{{ $cell->type }}</td>
            <td>{{ $cell->x }}</td>
            <td>{{ $cell->y }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="no-cells">セルが存在しません。</td>
        </tr>
    @endforelse
    </tbody>
</table>

<a href="{{ route('stage.index') }}" class="back-link">ステージ一覧に戻る</a>

</body>
</html>
