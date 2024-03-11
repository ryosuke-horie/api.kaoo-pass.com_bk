<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Console\CliDumper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * User(ジム)権限でログインする
     *
     * @return User
     */
    protected function login()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /**
     * DB のテーブルに入っているデータを出力する
     */
    protected function dumpdb(): void
    {
        if (class_exists(CliDumper::class)) {
            CliDumper::resolveDumpSourceUsing(fn () => null); // ファイル名や行数の出力を消す
        }

        // Laravel Ver.11 以降は、Schema::getTables() とする
        foreach (Schema::getTables() as $table) {
            if (isset($table->name)) {
                $name = $table->name;
            } else {
                $table = (array) $table;
                $name = reset($table);
            }

            if (in_array($name, ['migrations'], true)) {
                continue;
            }

            $collection = DB::table($name)->get();

            if ($collection->isEmpty()) {
                continue;
            }

            $data = $collection->map(function ($item) {
                unset($item->created_at, $item->updated_at);

                return $item;
            })->toArray();

            dump(sprintf('■■■■■■■■■■■■■■■■■■■ %s %s件 ■■■■■■■■■■■■■■■■■■■', $name, $collection->count()));
            dump($data);
        }

        $this->assertTrue(true);
    }

    #[Test]
    public function テスト環境で実行されることをテスト()
    {
        $this->assertEquals('testing', config('app.env'));
    }
}
