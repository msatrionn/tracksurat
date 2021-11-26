<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_surat_masuk', function (Blueprint $table) {
            $table->increments('no_agenda');
            $table->string('no_surat', 20);
            $table->string('dari', 50);
            $table->string('kepada', 50);
            $table->string('perihal', 100);
            $table->string('lampiran', 50);
            $table->date('tanggal_surat');
            $table->string('jenis_surat', 20);
            $table->string('status_disposisi', 20)->default('belum disposisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_surat_masuk');
    }
}
