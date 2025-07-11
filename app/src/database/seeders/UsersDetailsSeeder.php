<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class UsersDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // すでに User が存在している前提
        $users = User::all();

        foreach ($users as $user) {
            $user->detail()->create(
                UserDetail::factory()->make()->toArray()
            );
        }
    }
}
