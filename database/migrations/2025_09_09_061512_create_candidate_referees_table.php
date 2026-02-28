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
        Schema::create('candidate_referees', function (Blueprint $table) {
             $table->id();
            $table->string('refereename', 255)->nullable();
            $table->string('organisation', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->integer('telephone')->nullable();
            $table->string('refereeaddress', 255)->nullable();
            $table->string('refereeemail', 255)->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_referees');
    }
};
