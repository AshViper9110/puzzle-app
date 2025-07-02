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

        Item::create([
            'name' => '月影',
            'type' => '薙刀',
        ]);
        Item::create([
            'name' => '刃雫',
            'type' => '短剣',
        ]);
        Item::create([
            'name' => '蒼天',
            'type' => '長剣',
        ]);

        Amounts::create([
            'user_id' => '1',
            'item_id' => '2',
        ]);
        Amounts::create([
            'user_id' => '1',
            'item_id' => '1',
        ]);
        Amounts::create([
            'user_id' => '2',
            'item_id' => '3',
        ]);
    }
}
