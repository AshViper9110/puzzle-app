@extends('layouts.app')

@section('title', 'ダッシュボード')
@section('description', '管理画面のステージ作成')

@section('content')
    <div class="container">
        <div class="header mb-4">
            <h1 class="main-title">
                <i class="fas fa-layer-group"></i>
                StageCreate
            </h1>
            <p class="page-subtitle text-muted">ステージ作成</p>
        </div>

        <!-- アップロードフォーム -->
        <form id="stageUploadForm" method="POST" action="{{ route('stage.upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="stage-info mb-3">
                <label class="form-label">ステージ名</label>
                <input type="text" id="stageName" name="stage_name" class="form-control" placeholder="例: Stage1"
                       required>
            </div>

            <!-- ダミーの file input -->
            <input type="file" id="jsonFile" name="json_file" class="d-none" accept=".json">

            <!-- グリッドエディタ -->
            <div id="stage-editor" class="p-4 border rounded bg-white shadow-sm mb-3">
                <!-- ツールバー -->
                <div class="toolbar d-flex gap-2 mb-3">
                    <button type="button" class="tool-btn active" data-type="ground">
                        <span class="tile ground"></span> Ground
                    </button>
                    <button type="button" class="tool-btn" data-type="boxes">
                        <span class="tile box"></span> Box
                    </button>
                    <button type="button" class="tool-btn" data-type="goal">
                        <span class="tile goal"></span> Goal
                    </button>
                    <button type="button" class="tool-btn" data-type="empty">
                        <span class="tile empty"></span> 消す
                    </button>
                    <button type="button" class="btn btn-success ms-auto" onclick="uploadStage()">
                        <i class="fas fa-upload"></i> アップロード
                    </button>
                    <button type="button" class="btn btn-warning" onclick="downloadStage()">
                        <i class="fas fa-download"></i> ダウンロード
                    </button>
                </div>

                <!-- グリッド -->
                <div id="grid" class="grid"></div>
            </div>
        </form>

        <div class="action-section mb-4">
            <a href="/stage/index" class="btn btn--primary">
                <i class="fas fa-home"></i> ステージリストに戻る
            </a>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --transition: all 0.3s ease;
            --border-radius: 16px;
            --primary-color: #4fc3f7;
            --success-color: #81c784;
            --warning-color: #ffb74d;
            --info-color: #64b5f6;
            --danger-color: #e53e3e;
            --purple-color: #ba68c8;
            --card-bg: rgba(255, 255, 255, 0.1);
            --border-color: rgba(255, 255, 255, 0.1);
        }

        /* ベースレイアウト */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* =========================
           共通ヘッダー / サブタイトル
        ========================= */
        .header {
            text-align: center;
            margin-bottom: 60px;
        }

        .main-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 16px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--purple-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            margin-top: 12px;
        }

        .title-icon {
            margin-right: 16px;
            text-shadow: 0 0 10px rgba(186, 104, 200, 0.5);
        }

        /* =========================
           ボタン
        ========================= */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 2px solid transparent;
            transition: var(--transition);
        }

        .btn--small {
            padding: 8px 16px;
            font-size: 0.9rem;
            border-radius: 20px;
        }

        .btn--primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2196f3 100%);
            color: #fff;
            border-color: rgba(79, 195, 247, 0.3);
        }

        .btn--success {
            background: linear-gradient(135deg, var(--success-color) 0%, #66bb6a 100%);
            color: #fff;
            border-color: rgba(129, 199, 132, 0.3);
        }

        .btn--danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #c53030 50%, var(--danger-color) 100%);
            color: #fff;
            border-color: rgba(229, 62, 62, 0.3);
        }

        .btn--warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #ffa726 100%);
            color: #fff;
            border-color: rgba(255, 183, 77, 0.3);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .btn--success:hover {
            border-color: rgba(129, 199, 132, 0.6);
            box-shadow: 0 15px 40px rgba(129, 199, 132, 0.3);
        }

        /* =========================
           フォーム要素
        ========================= */
        .stage-info {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 32px;
            backdrop-filter: blur(20px);
            margin-bottom: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .form-label {
            display: block;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #fff;
        }

        .form-control {
            width: 100%;
            padding: 16px 24px;
            border-radius: 50px;
            border: 2px solid var(--border-color);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 1.1rem;
            backdrop-filter: blur(20px);
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 20px rgba(79, 195, 247, 0.3);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* =========================
           ステージエディター
        ========================= */
        .stage-editor {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 32px;
            backdrop-filter: blur(20px);
            margin-bottom: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            position: relative;
            overflow: hidden;
        }

        .stage-editor::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--purple-color) 100%);
        }

        /* ツールバー */
        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 32px;
            align-items: center;
        }

        .tool-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 25px;
            border: 2px solid var(--border-color);
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .tool-btn:hover {
            border-color: var(--primary-color);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 195, 247, 0.2);
        }

        .tool-btn.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--info-color) 100%);
            border-color: rgba(79, 195, 247, 0.5);
            color: #fff;
            box-shadow: 0 10px 20px rgba(79, 195, 247, 0.3);
        }

        .ms-auto {
            margin-left: auto;
        }

        /* タイル */
        .tile {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .tile.ground {
            background: linear-gradient(135deg, #8d6e63 0%, #5d4037 100%);
        }

        .tile.box {
            background: linear-gradient(135deg, var(--warning-color) 0%, #ff8f00 100%);
        }

        .tile.goal {
            background: linear-gradient(135deg, var(--success-color) 0%, #388e3c 100%);
        }

        .tile.empty {
            background: rgba(255, 255, 255, 0.1);
        }

        /* グリッド */
        .grid {
            display: grid;
            grid-template-columns: repeat(16, 1fr);
            gap: 2px;
            max-width: 750px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .grid-cell {
            aspect-ratio: 1;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }

        .grid-cell:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 10;
        }

        .grid-cell.ground {
            background: linear-gradient(135deg, #8d6e63 0%, #5d4037 100%);
        }

        .grid-cell.box {
            background: linear-gradient(135deg, var(--warning-color) 0%, #ff8f00 100%);
        }

        .grid-cell.goal {
            background: linear-gradient(135deg, var(--success-color) 0%, #388e3c 100%);
        }

        .grid-cell.empty {
            background: rgba(255, 255, 255, 0.05);
        }

        /* アクションセクション */
        .action-section {
            text-align: center;
            padding: 32px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* レスポンシブ */
        @media (max-width: 768px) {
            body {
                padding: 20px 15px;
            }

            .main-title {
                font-size: 2.5rem;
            }

            .stage-info, .stage-editor, .action-section {
                padding: 24px;
            }

            .toolbar {
                justify-content: center;
            }

            .grid {
                grid-template-columns: repeat(12, 1fr);
                max-width: 600px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .main-title {
                font-size: 2rem;
            }

            .grid {
                grid-template-columns: repeat(9, 1fr);
                max-width: 450px;
            }

            .toolbar {
                flex-direction: column;
            }

            .tool-btn {
                width: 100%;
                justify-content: center;
            }
        }

        .d-none {
            display: none;
        }

        .mb-3 {
            margin-bottom: 24px;
        }

        .mb-4 {
            margin-bottom: 32px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let currentTile = 'ground';

        // JSONデータのベース
        let stage = {ground: [], boxes: [], goal: []};

        // ツール切替
        document.querySelectorAll('.tool-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tool-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentTile = btn.dataset.type;
            });
        });

        // グリッド生成
        const gridWidth = 16, gridHeight = 9;
        const grid = document.getElementById('grid');

        for (let y = 0; y < gridHeight; y++) {
            for (let x = 0; x < gridWidth; x++) {
                const cell = document.createElement('div');
                cell.classList.add('grid-cell');

                // 中心を原点にする
                cell.dataset.x = x - Math.floor(gridWidth / 2);   // -7 ~ 7
                cell.dataset.y = Math.floor(gridHeight / 2) - y;  // 4 ~ -4

                cell.addEventListener('click', () => {
                    const cx = parseInt(cell.dataset.x);
                    const cy = parseInt(cell.dataset.y);

                    // 既存座標削除
                    for (const key in stage) {
                        stage[key] = stage[key].filter(p => !(p.x === cx && p.y === cy));
                    }

                    // タイル配置
                    cell.className = 'grid-cell';
                    if (currentTile !== 'grid-cell.empty') {
                        let cssClass = currentTile === 'boxes' ? 'box' : currentTile;
                        cell.classList.add(cssClass);
                        stage[currentTile].push({x: cx, y: cy});
                    }
                });
                grid.appendChild(cell);
            }
        }

        // JSONをファイル化してフォームに添付してアップロード
        function uploadStage() {
            const stageName = document.getElementById('stageName').value.trim();
            if (!stageName) {
                alert("ステージ名を入力してください！");
                return;
            }

            const jsonStr = JSON.stringify(stage, null, 2);
            const file = new File([jsonStr], stageName + '.json', {type: 'application/json'});
            const dt = new DataTransfer();
            dt.items.add(file);

            const fileInput = document.getElementById('jsonFile');
            fileInput.files = dt.files;

            document.getElementById('stageUploadForm').submit();
        }

        function downloadStage() {
            const stageName = document.getElementById('stageName').value.trim();
            if (!stageName) {
                alert("ステージ名を入力してください！");
                return;
            }

            const jsonStr = JSON.stringify(stage, null, 2);
            const blob = new Blob([jsonStr], {type: 'application/json'});

            // ダウンロード用リンクを生成
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = stageName + '.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    </script>
@endpush
