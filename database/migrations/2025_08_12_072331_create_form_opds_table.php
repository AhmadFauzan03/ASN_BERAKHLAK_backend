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
           $table->string('id')->primary();
            $table->string('id_user');
            $table->string('id_status')->default('ST-002'); // default pending
            $table->integer('periode_bulan');
            $table->integer('periode_tahun');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
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
