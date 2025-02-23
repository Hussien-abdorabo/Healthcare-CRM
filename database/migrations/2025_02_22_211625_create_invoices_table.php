<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            /*
             * patient_id (FK to Users - Patient)
doctor_id (FK to Users - Doctor)
appointment_id (FK to Appointments)
amount
payment_status (enum: 'pending', 'paid', 'overdue', 'cancelled')
payment_method (enum: 'cash', 'credit_card', 'insurance')
issued_at
due_date
transaction_id (for online payments)

*/
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');

            $table->decimal('amount',20,2)->default(0);
            $table->enum('payment_status',['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->enum('payment_method',['cash','credit_card', 'insurance'])->default('cash');
            $table->dateTime('issued_at')->nullable();
            $table->date('due_at')->nullable();
            $table->string('transaction_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
