<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ユーザーを作成
        $this->call(UserSeeder::class);
        // メンバーを作成
        $this->call(MemberSeeder::class);
    }
}
