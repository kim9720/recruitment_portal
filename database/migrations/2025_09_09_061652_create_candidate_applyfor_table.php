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
        Schema::create('candidate_applyfor', function (Blueprint $table) {
            $table->id();
            $table->string('cover_letter', 255)->nullable();
            $table->integer('expected_salary')->nullable();
            $table->integer('job_id');
            $table->integer('user_id')->nullable();
            $table->date('applied_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_applyfor');
    }
};
