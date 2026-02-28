<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('content');
            $table->string('type', 50);

            // foreign key kwa jobs_to_applay.job_id
            $table->unsignedBigInteger('job_id')->nullable();
            $table->foreign('job_id')
                ->references('job_id')
                ->on('jobs_to_applay')
                ->cascadeOnDelete();

            // foreign key kwa users.id
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->dateTime('date')->useCurrent();
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
