<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => $this->faker->unique()->numberBetween(10000, 99999),
            'invoice_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'client_id' => \App\Models\Client::factory(),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
