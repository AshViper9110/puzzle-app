<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(\App\Models\Achievement::class, 'achievement_user')
            ->withTimestamps();
    }
}
