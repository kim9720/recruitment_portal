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
        Schema::create('candidate_education', function (Blueprint $table) {
             $table->id('rec_id');
            $table->integer('user_id');
            $table->string('institute', 200)->nullable();
            $table->string('year', 10)->nullable();
            $table->string('score', 15)->nullable();
            $table->string('type', 150)->nullable()->comment('School, +2,degree,pg,other');
            $table->string('educationlevel', 255)->nullable();
            $table->string('specialization', 255)->nullable();
            $table->string('educationstartdate', 255)->nullable();
            $table->string('educationenddate', 255)->nullable();
            $table->string('certificate_path', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_education');
    }
};
