<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Account;
use PHPUnit\Framework\Attributes\Test;

class AccountTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    #[Test]
    public function 初期状態はデータがないことをテスト(): void
    {
        $this->assertEquals(0, Account::count());
    }

    #[Test]
    public function データの追加ができることをテスト(): void
    {
        Account::factory()->create();
        $this->assertEquals(1, Account::count());
    }
}
