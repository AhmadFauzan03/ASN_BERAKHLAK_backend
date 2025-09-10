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
            $table->string('id')->unique()->primary();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('username');
            $table->string('password');
            $table->string('id_opd')->nullable();
            $table->string('id_peran');
            $table->timestamps();


            $table->foreign('id_opd')->references('id')->on('opds')->onDelete('cascade');
            $table->foreign('id_peran')->references('id')->on('perans')->onDelete('cascade');
            
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
