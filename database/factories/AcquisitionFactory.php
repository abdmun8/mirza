<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Acquisition>
 */
class AcquisitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'nip' => $this->faker->numerify('##########'),
            'name' => $this->faker->name(),
            'position' => $this->faker->jobTitle(),
            'product' => $this->faker->word(),
            'branch_id' => $this->faker->randomNumber(5, true),
            'month' => $this->faker->numberBetween(1, 12),
            'year' => 2025,
            'customer' => $this->faker->name(),
        ];
    }
}
