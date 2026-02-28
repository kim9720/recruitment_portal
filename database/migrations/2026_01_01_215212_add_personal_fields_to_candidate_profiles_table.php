<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('candidate_profile', function (Blueprint $table) {
            $table->string('id_number')->nullable()->after('reg_country');
            $table->string('passport_number')->nullable()->after('id_number');
            $table->date('date_of_birth')->nullable()->after('last_name');
            $table->string('marital_status')->nullable()->after('date_of_birth');
        });
    }

    public function down()
    {
        Schema::table('candidate_profile', function (Blueprint $table) {
            $table->dropColumn([
                'passport_number',
                'id_number',
                'date_of_birth',
                'marital_status'
            ]);
        });
    }
};

