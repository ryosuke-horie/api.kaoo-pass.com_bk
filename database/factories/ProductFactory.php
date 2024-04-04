<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'account_id' => Account::factory(),
            'stripe_price_id' => $this->faker->word(),
            'stripe_product_id' => $this->faker->word(),
            'price' => $this->faker->randomNumber(),
            'description' => $this->faker->text(),
        ];
    }

    /**
     * テストアカウント用のデータを設定
     */
    public function testAccount(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'account_id' => 1,
                'stripe_price_id' => 'price_1P1KoSCeSD0euoafrn0i4N13',
                'stripe_product_id' => 'prod_PqptMzaXlcvfOP',
            ];
        });
    }
}
