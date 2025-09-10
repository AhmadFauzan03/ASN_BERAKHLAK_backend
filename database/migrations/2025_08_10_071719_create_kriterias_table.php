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
        Schema::create('kriterias', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('kriteria');
            $table->string('deskripsi');
            $table->string('id_poin');
            $table->string('id_sub_kriteria');
            $table->timestamps();

            $table->foreign('id_poin')->references('id')->on('poins')->onDelete('cascade');
            $table->foreign('id_sub_kriteria')->references('id')->on('sub_kriterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};
