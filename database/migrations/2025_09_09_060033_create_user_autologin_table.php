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
        Schema::create('user_autologin', function (Blueprint $table) {
            $table->char('key_id', 32);
            $table->integer('user_id')->default(0);
            $table->string('user_agent', 150);
            $table->string('last_ip', 40);
            $table->timestamp('last_login')->useCurrent();
            $table->primary(['key_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_autologin');
    }
};
