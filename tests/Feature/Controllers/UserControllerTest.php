<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /***********************************************************
     *                 会員一覧機能のテスト開始                  *
     ***********************************************************/

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
    public function case3_ユーザーがいない場合空を返す(): void
    {
        // テスト用のAccountを作成
        $testAccount = Account::factory()->testAccount()->create();

        // レスポンスが空であることを検証
        $response = $this->actingAs($testAccount)->get('/api/users');
        $response->assertJson([]);
    }

    #[Test]
    public function case4_ユーザーがいる場合の確認(): void
    {
        // テスト用のAccountを作成
        $testAccount = Account::factory()->testAccount()->create();

        // テスト用のUserを作成
        User::factory()->count(3)->create([
            'account_id' => $testAccount->id,
        ]);

        // ユーザーが取得できることを検証
        $response = $this->actingAs($testAccount)->get('/api/users');
        $response->assertJsonCount(3);
    }

    #[Test]
    public function case5_別アカウントのユーザーは取得できない(): void
    {
        // テスト用のAccountを作成
        $testAccount = Account::factory()->testAccount()->create();

        // テスト用のUserを作成
        User::factory()->count(3)->create([
            'account_id' => $testAccount->id,
        ]);

        // 別アカウントのUserを作成
        $anotherAccount = Account::factory()->create();
        User::factory()->count(3)->create([
            'account_id' => $anotherAccount->id,
        ]);

        // ユーザーが取得できることを検証
        $response = $this->actingAs($testAccount)->get('/api/users');
        $response->assertJsonCount(3);
    }

    /***********************************************************
     *                 会員登録機能のテスト開始                  *
     ***********************************************************/
    #[Test]
    public function add_case1_未ログインのステータスコードの検証(): void
    {
        $response = $this->post('/api/users');
        $response->assertStatus(302);
    }

    // #[Test]
    // public function add_case2_ログイン時のステータスコードの検証(): void
    // {
    //     $account = Account::factory()->testAccount()->create();
    //     $this->actingAs($account);
    //     $response = $this->post('/api/users');
    //     $response->assertStatus(200);
    // }
}
