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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->integer('role_id')->nullable();
            $table->string('username', 50);
            $table->string('password', 255);
            $table->string('email', 100);
            $table->boolean('activated')->default(1);
            $table->boolean('banned')->default(0);
            $table->string('ban_reason', 255)->nullable();
            $table->string('new_password_key', 50)->nullable();
            $table->dateTime('new_password_requested')->nullable();
            $table->string('new_email', 100)->nullable();
            $table->string('new_email_key', 50)->nullable();
            $table->string('last_ip', 40);
            $table->dateTime('last_login')->nullable();
            $table->dateTime('created')->nullable();
            $table->timestamp('modified')->useCurrent()->useCurrentOnUpdate();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb3';
            $table->collation = 'utf8mb3_bin';
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
