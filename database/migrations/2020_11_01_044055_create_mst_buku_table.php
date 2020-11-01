<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_barang', function (Blueprint $table) {
            $table->string('id',50);
            $table->string('nama');
            $table->string('kategori');
            $table->string('penulis')->nullable();
            $table->string('penerbit')->nullable();
            $table->char('tahun_terbit',5)->nullable();
            $table->string('isbn')->nullable();
            $table->integer('halaman')->nullable();
            $table->integer('jumlah');
            $table->string('gambar')->nullable();
            $table->text('sinopsis')->nullable();
            $table->string('nama_rak');
            $table->string('lokasi_rak')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_barang');
    }
}
