<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    // 必要に応じてfillableを指定
    protected $fillable = [
        'id',
        'name'
    ];

    /**
     * ステージに属するセル（地形/ボックス/ゴール）を取得
     */
    public function cells(): HasMany
    {
        return $this->hasMany(StageCell::class);
    }

    /**
     * 特定タイプのセルのみ取得したいとき（例: ground）
     */
    public function groundCells(): HasMany
    {
        return $this->hasMany(StageCell::class)->where('type', 'ground');
    }

    public function boxCells(): HasMany
    {
        return $this->hasMany(StageCell::class)->where('type', 'box');
    }

    public function goalCells(): HasMany
    {
        return $this->hasMany(StageCell::class)->where('type', 'goal');
    }
}
