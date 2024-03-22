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
}
