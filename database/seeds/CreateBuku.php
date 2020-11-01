<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class CreateBuku extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Buku::create([
        	'id'		=> 'B'.time(),
	        'nama'		=> 'Buku BQS',
	        'kategori' 	=> 'ilmu Komplit & Novel',
	        'penulis'	=> 'ginanjar BQS',
	        'penerbit'	=> 'BQS Corp',
	        'tahun_terbit'=> '2030',
	        'isbn'		=> '111222211111122',
	        'halaman'	=> '1500',
	        'jumlah'	=> '1001',
	        'gambar' 	=> 'buku/bqs_buku.jpg',
	        'sinopsis' => 'Menceritakan perjalanan hidup dan sort cut sukses',
	        'nama_rak' 	=> 'rak ilmu pengetahuan',
        ]);
    }
}
