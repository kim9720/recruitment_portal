<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidate_profile', function (Blueprint $table) {
            $table->string('landline')->nullable()->change();
            $table->string('expectations')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('candidate_profile', function (Blueprint $table) {
            $table->string('landline')->nullable(false)->change();
            $table->string('expectations')->nullable(false)->change();
        });
    }
};
