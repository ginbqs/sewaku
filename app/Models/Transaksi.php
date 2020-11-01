<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use Softdelete;
    protected $table = 'trans_peminjaman';
    protected $fillable = [
        'no_pinjam','tgl_pinjam','tgl_kembali','total_terlambat','total_bayar','total_denda','status','buku_id','peminjam_id','petugas_id'
    ];
}
