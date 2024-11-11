<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(20),
            'lead' => $this->faker->text(15),
            'members' => $this->faker->text(30),
            'fecha_entrega' => $this->faker->date(),
            'country_id' => $this->faker->numberBetween(1,15)
        ];
    }
}
