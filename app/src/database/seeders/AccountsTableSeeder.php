<?php

namespace Database\Seeders;

use App\Models\Accounts;
use App\Models\Amounts;
use App\Models\Item;
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
            'password' => Hash::make('TestPassword'),
        ]);
        Accounts::create([
            'name' => 'AshViper',
            'password' => Hash::make('aiki9110'),
        ]);
    }
}
