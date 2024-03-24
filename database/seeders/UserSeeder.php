<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テストアカウントを取得
        $account = Account::where('email', 'test@example.com')->first();

        // テストアカウントに100件のユーザーを作成
        User::factory()->count(100)->create([
            'account_id' => $account->id,
        ]);
    }
}
