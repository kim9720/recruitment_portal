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
    Schema::create('candidate_profile', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')
              ->constrained('users')
              ->cascadeOnDelete();
        $table->string('user_slug', 110)->nullable();
        $table->string('login_id', 110);
        $table->string('first_name', 150);
        $table->string('middle_name', 255)->nullable();
        $table->string('last_name', 150);
        $table->string('landline', 50);
        $table->text('address');
        $table->string('city', 100)->nullable();
        $table->string('email', 150);
        $table->integer('pin')->nullable();
        $table->string('expectations', 300);
        $table->string('resumefile', 300);
        $table->string('mobile', 50);
        $table->string('secondmobile', 255)->nullable();
        $table->integer('applied_for')->nullable()
              ->comment('job_id will be added');
        $table->integer('status')->default(0)
              ->comment('0=Active,1=hired,2=Rejectlist,3=shortlisted');
        $table->string('reg_country', 255)->nullable();
        $table->string('gender', 255)->nullable();
        $table->string('highqualification', 255)->nullable();
        $table->integer('yearsofexperience')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_profile');
    }
};
