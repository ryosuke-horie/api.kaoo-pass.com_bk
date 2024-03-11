<?php

namespace Tests\Unit\Models;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    #[Test]
    public function 会員情報が作成できることをテスト()
    {
        $member = Member::factory()->create();
        $this->assertInstanceOf(Member::class, $member);
    }
}
