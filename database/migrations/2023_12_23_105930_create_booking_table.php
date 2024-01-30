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
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->unique();
            $table->string('phone', 255)->nullable();
            $table->date('booking_date')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('slot_id');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('slot_id')->references('id')->on('slots');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
