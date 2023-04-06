<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'national_id'=> $this->faker->unique()->randomNumber(5),
            'mobile'=> $this->faker->phoneNumber(),
            'gender'=> 'M',
            'birth_day'=>$this->faker->date(),
            'avatar'=> 'defaultImages/default.jpg',
        ];
    }
}
