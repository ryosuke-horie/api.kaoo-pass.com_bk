<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
