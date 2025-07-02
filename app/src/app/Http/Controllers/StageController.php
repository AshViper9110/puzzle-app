<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Models\Stage;
use App\Models\StageCell;
use Illuminate\Http\Request;

class StageController extends Controller
{
    // 全ステージ表示
    public function index()
    {
        $stages = Stage::all();
        return view('stage.index', compact('stages'));
    }

    // 個別ステージ詳細
    public function show($id)
    {
        $stage = Stage::with('cells')->findOrFail($id);
        return view('stage.show', compact('stage'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'json_file' => 'required|file|mimes:json'
        ]);

        $file = $request->file('json_file');
        $jsonData = json_decode(File::get($file), true);

        if (!$jsonData || !is_array($jsonData)) {
            return redirect()->route('stage.index')->with('error', '無効なJSONファイルです。');
        }

        // アップロードされたファイル名（拡張子を除く）を取得
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // ステージを追加
        $stage = Stage::create([
            'name' => $originalName, // ファイル名を使用
            'description' => 'アップロードされたJSONから作成',
        ]);

        // セルを保存
        foreach (['ground', 'boxes', 'goal'] as $type) {
            if (!isset($jsonData[$type])) {
                continue;
            }

            foreach ($jsonData[$type] as $pos) {
                StageCell::create([
                    'stage_id' => $stage->id,
                    'x' => $pos['x'],
                    'y' => $pos['y'],
                    'type' => $type === 'boxes' ? 'box' : $type,
                ]);
            }
        }

        return redirect()->route('stage.index')->with('success', 'ステージ「' . $originalName . '」が追加されました。');
    }

    public function get($id)
    {
        $stage = Stage::with('cells')->findOrFail($id);

        return response()->json([
            'id' => $stage->id,
            'name' => $stage->name,
            'description' => $stage->description,
            'cells' => $stage->cells->map(function ($cell) {
                return [
                    'x' => $cell->x,
                    'y' => $cell->y,
                    'type' => $cell->type,
                ];
            }),
        ]);
    }

    public function count()
    {
        $count = Stage::count();

        return response()->json([
            'count' => $count
        ]);
    }
}

