<?php

namespace Database\Seeders;

use App\Models\Accounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Accounts::create([
            'name' => 'Test Account',
            'password' => Hash::make('TestPassword')
        ]);
    }
}
