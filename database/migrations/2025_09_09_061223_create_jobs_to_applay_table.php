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
        Schema::create('jobs_to_applay', function (Blueprint $table) {
            $table->id('job_id');
            $table->string('job_title', 150);
            $table->text('introduction');
            $table->text('responsibilities');
            $table->text('skillset');
            $table->integer('status');
            $table->string('location', 255)->nullable();
            $table->date('deadline')->nullable();
            $table->string('category', 255)->nullable();
            $table->string('jobfunction', 255)->nullable();
            $table->string('minimumqualification', 255)->nullable();
            $table->integer('experiencelenght')->nullable();
            $table->integer('countview')->default(0);
            $table->integer('expired_jobs')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs_to_applay');
    }
};
