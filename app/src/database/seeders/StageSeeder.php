<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Stage;

class StageSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = storage_path('app/stage1.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("JSONファイルが見つかりません: $jsonPath");
            return;
        }

        $json = json_decode(File::get($jsonPath), true);

        // ステージを作成
        $stage = Stage::create([
            'name' => 'Stage 1',
            'description' => 'JSONから読み込んだステージ',
        ]);

        // ground, boxes, goal に分けて保存
        foreach (['ground', 'boxes', 'goal'] as $type) {
            if (!isset($json[$type])) {
                continue;
            }

            foreach ($json[$type] as $pos) {
                DB::table('stage_cells')->insert([
                    'stage_id' => $stage->id,
                    'x' => $pos['x'],
                    'y' => $pos['y'],
                    'type' => $type === 'boxes' ? 'box' : $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info("ステージ '{$stage->name}' を登録しました。");
    }
}
