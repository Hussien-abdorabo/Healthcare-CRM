<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return array(

            'appointment_date' => fake()->dateTime('now')->format('Y-m-d'),
//            'appointment_time' => fake()->dateTime('now')->format('H:i:s'),
            'appointment_status' => $this->faker->randomElement(array('pending', 'approved', 'rejected')),
            'reason' => $this->faker->realText(),
            'notes' => $this->faker->realText(),
            "patient_id" => User::all()->random()->id,
            "doctor_id" => User::all()->random()->id

        );
    }
}
