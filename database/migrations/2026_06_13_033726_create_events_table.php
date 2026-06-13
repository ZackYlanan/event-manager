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
            $table->increments('id'); // INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('event_categories')->onDelete('restrict');

            // Event details
            $table->string('title');
            $table->text('description');
            $table->string('venue')->default('TBA');
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('max_slots');
            $table->dateTime('registration_deadline');
            $table->string('status'); // pwede gawin enum pero let's stick with string muna
            
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
