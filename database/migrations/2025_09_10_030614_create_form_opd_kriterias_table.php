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
        Schema::create('form_opd_kriterias', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('form_opd_id');
            $table->string('nama_kriteria');
            $table->timestamps();

             $table->foreign('form_opd_id')->references('id')->on('form_opds')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_opd_kriterias');
    }
};
