<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AccountSeeder::class); // ジムアカウント用テーブル
        $this->call(UserSeeder::class);    // ジム会員用テーブル
        $this->call(ProductSeeder::class); // Stripe 商品用テーブル
    }
}
