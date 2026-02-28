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
        Schema::create('candidate_experience', function (Blueprint $table) {
           $table->id('exp_id');
            $table->integer('user_id');
            $table->string('company_name', 150)->nullable();
            $table->string('role', 150)->nullable();
            $table->string('months', 100)->nullable();
            $table->string('startdate', 255)->nullable();
            $table->string('enddate', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_experience');
    }
};
