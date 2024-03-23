<?php

namespace Tests;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\Test;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    #[Test]
    public function テスト環境で実行されていることを確認(): void
    {
        $this->assertEquals('testing', app()->environment());
    }

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
