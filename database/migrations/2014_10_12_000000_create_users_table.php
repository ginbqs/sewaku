<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id',50);
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('nis')->nullable();
            $table->string('ktp')->nullable();
            $table->string('jurusan')->nullable();
            $table->char('kelamin',1);
            $table->string('agama')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('no_hp');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('desa');
            $table->text('alamat');
            $table->string('foto')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
