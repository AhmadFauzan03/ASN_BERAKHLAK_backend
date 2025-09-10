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
        Schema::create('form_opds', function (Blueprint $table) {
           $table->string('id')->unique()->primary();
            $table->string('id_user');
            $table->string('keterangan')->nullable();
            $table->string('id_status');
            $table->timestamps();

           
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_status')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_opds');
    }
};
