<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransPeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('no_pinjam')->nullable();
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
            $table->integer('total_terlambat')->nullable();
            $table->integer('total_bayar');
            $table->integer('total_denda')->nullable();
            $table->char('status',1);
            $table->string('barang_id',50)->nullable();
            $table->string('peminjam_id',50)->nullable();
            $table->string('petugas_id',50)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('barang_id')->references('id')->on('mst_barang');
            $table->foreign('peminjam_id')->references('id')->on('users');
            $table->foreign('petugas_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_peminjaman');
    }
}
