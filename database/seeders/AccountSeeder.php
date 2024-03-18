<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        Account::create([
            'name' => 'testuser',
            'email' => 'test@examle.com',
            'password' => Hash::make('password'),
        ]);
    }
}
