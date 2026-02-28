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
        Schema::create('activity_logger', function (Blueprint $table) {
          $table->id('log_id');
            $table->integer('user_id');
            $table->text('activity');
            $table->string('activity_time', 100);
            $table->string('ip_address', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logger');
    }
};
