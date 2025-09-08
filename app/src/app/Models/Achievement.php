<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['content'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'achievement_user')
            ->withTimestamps();
    }
}
