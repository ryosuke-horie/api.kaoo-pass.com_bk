<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\User;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserControllerTest extends TestCase
{
    #[Test]
    public function case1_未ログイン時のステータスコードの検証(): void
    {
        $response = $this->get('/api/users');
        $response->assertStatus(302);
    }

    #[Test]
    public function case2_ログイン時のステータスコードの検証(): void
    {
        $account = Account::factory()->testAccount()->create();
        $this->actingAs($account);
        $response = $this->get('/api/users');
        $response->assertStatus(200);
    }

    #[Test]
    public function case3_ユーザー一覧の検証(): void
    {
        // Accountを作成しログイン
        $account = Account::factory()->testAccount()->create();
        $this->actingAs($account);
        // Userを3件作成
        User::factory()->count(3)->create();
        // ユーザー一覧を取得
        $response = $this->get('/api/users');

        // 3件のユーザーが返却されることを検証
        $response->assertJsonCount(3);
    }
}
