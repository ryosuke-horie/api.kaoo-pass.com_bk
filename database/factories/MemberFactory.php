<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'image1' => 'image1.jpg',
            'image2' => 'image2.jpg',
            'image3' => 'image3.jpg',
            'nickname' => $this->faker->userName,
        ];
    }
}
