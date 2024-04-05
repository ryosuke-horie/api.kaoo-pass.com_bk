<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    #[Test]
    public function ログインができることをテスト(): void
    {
        Account::factory()->testAccount()->create();
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // tokenが返却されることを検証
        $response->assertJsonStructure(['token']);
        // レスポンスの検証
        $response->assertStatus(200);
    }

    #[Test]
    public function ログインができないことをテスト(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'error@example.com',
            'password' => 'error',
        ]);

        // エラーメッセージが返却されることを検証
        $response->assertJson(['error' => '認証に失敗しました。']);
        // レスポンスの検証
        $response->assertStatus(401);
    }

    #[Test]
    public function パスワードが間違っている場合にエラーを返すことをテスト(): void
    {
        Account::factory()->testAccount()->create();
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'error',
        ]);

        // エラーメッセージが返却されることを検証
        $response->assertJson(['error' => '認証に失敗しました。']);
        // レスポンスの検証
        $response->assertStatus(401);
    }
}
