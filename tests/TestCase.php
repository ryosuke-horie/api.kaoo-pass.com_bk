<?php

namespace Tests;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * テスト用のアカウントでログインし、トークンを取得する
     */
    protected function loginAsAccount(): void
    {
        // Accountユーザーを作成
        Account::factory()->create();

        // ログインしてトークンを取得
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // トークンを取得
        $token = $response['token'];

        // ヘッダーにトークンをセット
        $this->withHeader('Authorization', "Bearer $token");
    }
}
