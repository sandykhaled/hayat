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
        Schema::table('client_follow_ups', function (Blueprint $table) {
            $table->string('days');
            $table->date('date')->nullable();
            $table->time('arrival_time')->nullable();
            $table->time('session_start')->nullable();
            $table->time('session_end')->nullable();
            $table->string('session_number');
            $table->string('doctor');
            $table->string('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_follow_ups', function (Blueprint $table) {
            //
        });
    }
};
