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

        // テストアカウントにユーザーを作成
        User::factory()->count(10)->create([
            'account_id' => $account->id,
        ]);
    }
}
