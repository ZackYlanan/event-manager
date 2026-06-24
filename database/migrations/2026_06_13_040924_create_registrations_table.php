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
        if (!Schema::hasTable('registrations')) {
            Schema::create('registrations', function (Blueprint $table) {
                $table->id();

                $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

                $table->string('registration_code', 20)->unique();
                $table->enum('attendance_status', ['Pending', 'Present', 'Absent'])->default('Pending');
                $table->timestamp('checked_in_at')->nullable();
                $table->timestamps();

                // this prevents the student for entering the same event twice
                $table->unique(['event_id', 'user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
