<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'name' => $this->faker->name(),
            // 'email' => $this->faker->email(),
            'national_id'=> $this->faker->randomNumber(2),
            // 'password' => '123456',
            'is_banned'=> '0',
        ];
    }
}
