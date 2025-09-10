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
        Schema::create('form_opd_kriteria_details', function (Blueprint $table) {
           $table->string('id')->primary();
            $table->string('form_opd_kriteria_id');
            $table->integer('nilai_poin')->default(0);
            $table->string('gambar')->nullable();
            $table->string('link_video')->nullable();
            $table->timestamps();

            $table->foreign('form_opd_kriteria_id')->references('id')->on('form_opd_kriterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_opd_kriteria_details');
    }
};
