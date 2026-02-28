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
        Schema::create('messages', function (Blueprint $table) {
           $table->id('msg_id');
            $table->string('to_user', 150);
            $table->string('to_email', 150);
            $table->string('subject', 150);
            $table->text('message');
            $table->integer('status')->default(0);
            $table->string('timestamp', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
