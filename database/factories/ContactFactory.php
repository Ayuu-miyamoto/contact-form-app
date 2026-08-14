<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'first_name' => $this->faker->firstName(),
        'last_name' => $this->faker->lastName(),
        'gender' => $this->faker->randomElement([1, 2, 3]),
        'email' => $this->faker->unique()->safeEmail(),
        'tel' => $this->faker->numerify('###########'),
        'address' => $this->faker->address(),
        'building' => $this->faker->secondaryAddress(),
        'detail' => $this->faker->realText(120),
        'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
    ];
    }
}
