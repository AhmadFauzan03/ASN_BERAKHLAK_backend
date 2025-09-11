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
        Schema::create('total_poins', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('id_user');
            $table->unsignedTinyInteger('periode_bulan');
            $table->unsignedSmallInteger('periode_tahun');
            $table->string('total_poin');
            $table->timestamps();


            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_poins');
    }
};
