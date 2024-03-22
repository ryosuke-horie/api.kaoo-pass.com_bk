<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    #[Test]
    public function 初期状態はデータがないことをテスト(): void
    {
        $this->assertEquals(0, User::count());
    }

    // #[Test]
    // public function データの追加ができることをテスト(): void
    // {
    //     User::factory()->create();
    //     $this->assertEquals(1, User::count());

    //     // Accountに属するため、Accountも1件作成されていることを確認
    //     $this->assertEquals(1, Account::count());
    // }
}
