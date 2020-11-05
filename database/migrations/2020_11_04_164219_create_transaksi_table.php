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
            $table->enum('status',['pinjam','kembali']);
            $table->text('keterangan');
            $table->string('user_id',15);

            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');
        });
        Schema::create('trans_stok_detail', function (Blueprint $table) {
            $table->string('id',5);
            $table->string('trans_stok_id',15);
            $table->string('barang_id',50);
            $table->integer('stok_awal');
            $table->integer('stok_pinjam');
            $table->integer('stok_sekarang');
            $table->text('keterangan');


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
