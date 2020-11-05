<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Barang extends Model
{
    use Softdeletes;
    protected $table = 'mst_barang';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id','nama','kategori','penulis','penerbit','tahun_terbit','isbn','halaman','jumlah','terpinjam','gambar','sinopsis','nama_rak','lokasi_rak',
    ];
    const order = ['nama' => 'ASC'];
    const columns = ['nama','kategori','gambar','jumlah','terpinjam'];

    public static function getAllBarang($input,$type='row'){
        $dt_produk = DB::table('mst_barang')
            ->select('mst_barang.*', DB::raw('@rownum:= @rownum +1 As rownum'))
            ->whereNull('deleted_at');
       
        if ($type!='total') {
            $i = 0;
            $search_value = $input['search'];
            if(!empty($search_value['value'])){
                foreach (self::columns as $item){
                    ($i==0) ? $dt_produk->where($item,'like', '%'.$search_value['value'].'%') : $dt_produk->orWhere($item,'like', '%'.$search_value['value'].'%');
                    $i++;
                }
            }

            $order_column = $input['order'];
            if($order_column[0]['column'] != 0){
                $dt_produk->orderBy(self::columns[($order_column[0]['column']-1)], $order_column['0']['dir']);
            } 
            else if(isset($input['order'])){
                $order = self::order;
                $dt_produk->orderBy(key($order), $order[key($order)]);
            }
            if ($type!='raw') {
                $length = $input['length'];
                if($length !== false){
                    if($length != -1) {
                        $dt_produk->offset($input['start']);
                        $dt_produk->limit($input['length']);
                    }
                }
            }
        }
        if ($type=='raw' || $type=='total') {
            $dt_produk = $dt_produk->count();
        }else{
            $dt_produk = $dt_produk->get();
        }
        
        return $dt_produk;
    }
}
