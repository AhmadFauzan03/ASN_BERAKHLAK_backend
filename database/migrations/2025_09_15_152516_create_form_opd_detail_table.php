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
        Schema::create('form_opd_details', function (Blueprint $table) {
             $table->string('id')->primary();
            $table->string('form_opd_id');
            $table->string('id_kriteria'); // KR-001 ... KR-006
            $table->string('file')->nullable(); // path file
            $table->string('link')->nullable(); // link tambahan
            $table->string('id_status')->default('ST-002'); // ST-002 = pending
            $table->integer('nilai_poin')->default(0);
             $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('form_opd_id')->references('id')->on('form_opds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('form_opd_detail');
    }
};
