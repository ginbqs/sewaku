<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_stok', function (Blueprint $table) {
            $table->string('id',15);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->date('tanggal_dikembalikan')->nullable();
            $table->integer('hari_telat')->nullable();
            $table->integer('total_bayar')->nullable();
            $table->integer('total_denda')->nullable();
            $table->integer('total_uang')->nullable();
            $table->integer('total_kembali')->nullable();
            $table->enum('status',['draft','pinjam','kembali']);
            $table->text('keterangan')->nullable();
            $table->string('user_id',15);
            $table->string('peminjam');

            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');
        });
        Schema::create('trans_stok_detail', function (Blueprint $table) {
            $table->string('id',5);
            $table->string('trans_stok_id',15);
            $table->string('barang_id',50);
            $table->string('nama_barang',50);
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();


            $table->foreign('barang_id')->references('id')->on('mst_barang');
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['id','trans_stok_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_stok_opname_detail');
        Schema::dropIfExists('trans_stok_opname');
    }
}
