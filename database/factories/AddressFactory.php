<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street_name'=> $this->faker->lastName(),
            'build_no'=> $this->faker->randomDigit(),
            'floor_no'=> $this->faker->randomDigit(),
            'flat_no'=> $this->faker->randomDigit(),
            'is_main'=> 1,
            // 'area_id'=> 1 | 2,
            // area_id and client_id
        ];
    }
}
