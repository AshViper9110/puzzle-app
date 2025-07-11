<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StageCell extends Model
{
    protected $fillable = ['id', 'stage_id', 'x', 'y', 'type'];

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }
}
