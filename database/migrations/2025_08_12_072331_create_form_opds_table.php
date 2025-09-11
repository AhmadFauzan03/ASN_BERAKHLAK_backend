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
            $table->string('id_kriteria');
            $table->unsignedTinyInteger('periode_bulan');
            $table->unsignedSmallInteger('periode_tahun');
            $table->string('gambar1')->nullable();
            $table->string('gambar2')->nullable();
            $table->string('gambar3')->nullable();
            $table->string('gambar4')->nullable();
            $table->string('gambar5')->nullable();
            $table->string('link_vid1')->nullable();
            $table->string('link_vid2')->nullable();
            $table->string('link_vid3')->nullable();
            $table->string('link_vid4')->nullable();
            $table->string('link_vid5')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('id_status');
            $table->timestamps();
            

           $table->foreign('id_kriteria')->references('id')->on('form_opd_kriterias')->onDelete('cascade');
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
