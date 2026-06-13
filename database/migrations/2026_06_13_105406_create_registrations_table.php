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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascasde');

            $table->string('full_name');
            $table->string('student_id')->nullable();
            $table->string('email');
            $table->string('course')->nullable();
            $table->string('registration_code')->unique();
            $table->string('attendence_status')->default('pending');//pending, checked-in
            $table->datetime('checkin_at')->nullable();

            $table->timestamps(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
