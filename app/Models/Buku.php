<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use Softdeletes;
    protected $table = 'mst_barang';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id','nama','kategori','penulis','penerbit','tahun_terbit','isbn','halaman','jumlah','gambar','sinopsis','nama_rak','lokasi_rak',
    ];
}
