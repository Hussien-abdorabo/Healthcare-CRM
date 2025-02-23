<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;
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
            'amount' => $this->faker->randomFloat(2, 10, 100),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'overdue', 'cancelled']),
            'payment_method' => $this->faker->randomElement(['cash','credit_card','insurance']),
            'issued_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'due_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'transaction_id' => $this->faker->uuid(),
            "patient_id" => User::all()->random()->id,
            "doctor_id" => User::all()->random()->id,
            'appointment_id' => Appointment::all()->random()->id,

        ];
    }
}
