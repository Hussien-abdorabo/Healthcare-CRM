<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'diagnosis' => $this->faker->sentence(),
            'treatment' => $this->faker->sentence(),
            'prescription' => $this->faker->sentence(),
            'notes'=> $this->faker->realText(),
            'attachment' => $this->faker->filePath(),
            "patient_id" => User::all()->random()->id,
            "doctor_id" => User::all()->random()->id
        ];
    }
}
