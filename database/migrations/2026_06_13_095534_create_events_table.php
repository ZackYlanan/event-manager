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
            $table->id(); //Primary key
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->foreignId('category_id')->constained('event_catergories')->onDelete('cascade');
            
            $table->string('title');
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('venue');
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->int('max_slots')->nullable;
            $table->datetime('registration_dealine')->nullable();
            $table->string('status')->default('upcoming');// upcoming, completed, cancelled
            $table->timestamps();//created_at and updated_at
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
