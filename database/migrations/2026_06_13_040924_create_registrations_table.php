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
            $table->increments('id'); // INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
            
            $table->unsignedInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->deleteCascade('cascade');

            $table->string('full_name');
            $table->string('student_id');
            $table->string('email');
            $table->string('course');

            $table->string('registration_code')->unique();
            $table->string('attendance_status')->default('pending'); // pending, present, absent
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'student_id']);
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
