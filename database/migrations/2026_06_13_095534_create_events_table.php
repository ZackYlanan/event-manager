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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('event_categories')->onDelete('restrict');

            // Event details
            $table->string('title', 255);
            $table->text('description');
            $table->string('venue', 255)->default('TBA');
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('maximum_slots');
            $table->date('registration_deadline');

            // enunm instead of string
            $table->enum('status', ['Draft', 'Published', 'Cancelled', 'Completed'])->default('Draft');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
