<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisi', function (Blueprint $table) {
            $table->increments('id_disposisi');
            $table->integer('no_agenda')->unsigned();
            $table->foreign('no_agenda')->references('no_agenda')->on('m_surat_masuk')->onDelete('cascade');
            $table->bigInteger('nip')->unsigned()->index()->nullable();
            $table->foreign('nip')->references('nip')->on('karyawan')->onDelete('cascade');
            $table->integer('id_status')->unsigned()->index()->nullable();
            $table->foreign('id_status')->references('id_status')->on('m_status')->onDelete('cascade');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('disposisi');
    }
}
