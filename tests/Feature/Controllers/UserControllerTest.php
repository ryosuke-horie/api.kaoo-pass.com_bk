<?php

namespace Tests\Feature\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    #[Test]
    public function case1_トークンがなければリダイレクトする()
    {
        $response = $this->get('/api/user');

        // status code を検証
        $response->assertStatus(302);
    }

    #[Test]
    public function case2_トークンがあればユーザー情報を返す()
    {
        // テスト用のアカウントでログインし、トークンを取得
        $this->loginAsAccount();

        // トークンを取得した状態でリクエストを送信
        $response = $this->get('/api/user');

        // status code を検証
        $response->assertStatus(200);
    }

    #[Test]
    public function case3_ユーザー情報を返す()
    {
        // テスト用のアカウントでログインし、トークンを取得
        $this->loginAsAccount();

        // トークンを取得した状態でリクエストを送信
        $response = $this->get('/api/user');

        // レスポンスの内容を検証
        $response->assertJson(['message' => 'hello']);
    }
}
