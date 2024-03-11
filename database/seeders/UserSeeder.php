<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ユーザーを作成
        User::create([
            'name' => 'ヒデズキック',
            'email' => 'sample@gmail.com',
            'password' => 'password',
        ]);
    }
}
