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
        .tool-btn {
            border: 1px solid #ccc;
            background: #f8f9fa;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tool-btn.active {
            border: 2px solid #007bff;
            background: #e9f3ff;
        }

        .tile {
            width: 20px;
            height: 20px;
            display: inline-block;
            border: 1px solid #999;
        }

        .tile.ground {
            background: gray;
        }

        .tile.box {
            background: brown;
        }

        .tile.goal {
            background: gold;
        }

        .tile.empty {
            background: white;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(15, 32px);
            grid-template-rows: repeat(9, 32px);
            gap: 1px;
            justify-content: center;
        }

        .cell {
            width: 32px;
            height: 32px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
        }

        .cell.ground {
            background: gray;
        }

        .cell.box {
            background: brown;
        }

        .cell.goal {
            background: gold;
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
        const gridWidth = 15, gridHeight = 9;
        const grid = document.getElementById('grid');

        for (let y = 0; y < gridHeight; y++) {
            for (let x = 0; x < gridWidth; x++) {
                const cell = document.createElement('div');
                cell.classList.add('cell');

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
                    cell.className = 'cell';
                    if (currentTile !== 'empty') {
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
    </script>
@endpush
