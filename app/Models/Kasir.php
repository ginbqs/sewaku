<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Kasir extends Model
{
    protected $table = 'trans_stok';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'id','tanggal_pinjam','tanggal_kembali','tanggal_dikembalikan','hari_telat','total_bayar','total_denda','total_uang','total_kembali','status','keterangan','user_id','peminjam'
    ];
    const order = ['trans_stok.tanggal_pinjam' => 'DESC'];
    const columns = ['id','tanggal_pinjam','tanggal_kembali','tanggal_dikembalikan','hari_telat','total_bayar','total_denda','total_uang','total_kembali','status','keterangan','user_id','peminjam'];

    public static function getAllKasir($input,$type='row'){
        $dt_kasir = DB::table('trans_stok')
            ->select('trans_stok.*', DB::raw('@rownum:= @rownum +1 As rownum'));
        if ($type!='total') {
            $i = 0;
            $search_value = $input['search'];
            if(!empty($search_value['value'])){
                foreach (self::columns as $item){
                    ($i==0) ? $dt_kasir->where($item,'like', '%'.$search_value['value'].'%') : $dt_kasir->orWhere($item,'like', '%'.$search_value['value'].'%');
                    $i++;
                }
            }

            $order_column = $input['order'];
            if($order_column[0]['column'] != 0){
                $dt_kasir->orderBy(self::columns[($order_column[0]['column']-1)], $order_column['0']['dir']);
            } 
            else if(isset($input['order'])){
                $order = self::order;
                $dt_kasir->orderBy(key($order), $order[key($order)]);
            }
            if ($type!='raw') {
                $length = $input['length'];
                if($length !== false){
                    if($length != -1) {
                        $dt_kasir->offset($input['start']);
                        $dt_kasir->limit($input['length']);
                    }
                }
            }
        }
        if ($type=='raw' || $type=='total') {
            $dt_kasir = $dt_kasir->count();
        }else{
            $dt_kasir = $dt_kasir->get();
        }
        return $dt_kasir;
    }
}
