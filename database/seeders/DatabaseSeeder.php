<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(20)->create();
         Appointment::factory(20)->create();
        Invoice::factory(20)->create();
        MedicalRecord::factory(20)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
