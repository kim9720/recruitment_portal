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
        Schema::create('candidate_jobalert', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('jobfunction', 255)->nullable();
            $table->integer('email')->nullable();
            $table->integer('sms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_jobalert');
    }
};
