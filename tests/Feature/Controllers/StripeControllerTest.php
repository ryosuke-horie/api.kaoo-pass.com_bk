<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StripeControllerTest extends TestCase
{
    /***********************************************************
     *                 Stripeアカウント作成機能のテスト開始                  *
     ***********************************************************/

    #[Test]
    public function case1_未ログイン時のステータスコードの検証(): void
    {
        $response = $this->get('/api/stripe/create');
        $response->assertStatus(302);
    }

    #[Test]
    public function case2_Stripeのシークレットキーが設定されていない場合のエラーレスポンス(): void
    {
        $account = Account::factory()->testAccount()->create();
        $this->actingAs($account);
        config(['stripe.stripe_secret_key' => null]);
        $response = $this->get('/api/stripe/create');
        $response->assertStatus(500);
    }

    #[Test]
    public function case3_Stripeアカウント作成の確認(): void
    {
        $account = Account::factory()->testAccount()->create();
        $this->actingAs($account);
        $response = $this->get('/api/stripe/create');
        $response->assertStatus(200);
    }
}
