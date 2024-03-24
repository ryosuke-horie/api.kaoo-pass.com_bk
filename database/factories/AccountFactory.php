<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
        ];
    }

    /**
     * `test@example.com` `password`のアカウントを作成
     *
     *  * @return \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
     */
    public function testAccount(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => 'test@example.com',
            ];
        });
    }
}
