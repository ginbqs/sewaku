<?php

namespace App\Models\Kasir;

use Illuminate\Database\Eloquent\Model;
use DB;

class KasirDetail extends Model
{
    protected $table = 'trans_stok_detail';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'id','trans_stok_id','produk_id','jumlah','jumlah_fisik','selisih','harga','keterangan'
    ];
    const order = ['trans_produk.nama' => 'ASC'];
    const columns = ['trans_produk.nama','trans_stok_detail.produk_id','trans_stok_detail.jumlah','trans_stok_detail.jumlah_fisik','trans_stok_detail.harga','trans_stok_detail.keterangan'];

    public static function getAllKasirDetail($input,$type='row'){
        $dt_kasirDetail = DB::table('trans_stok_detail')
        	->join('trans_produk','trans_produk.id','=','trans_stok_detail.produk_id')
        	->join('mst_satuan','mst_satuan.id','=','trans_produk.satuan_id')
            ->select('trans_stok_detail.*','trans_produk.nama as trans_produk_nama' ,'mst_satuan.nama as mst_satuan_nama',DB::raw('@rownum:= @rownum +1 As rownum'))
            ->where('trans_stok_detail.trans_stok_id',$input['trans_stok_id']);
        if ($type!='total') {
            $i = 0;
            $search_value = $input['search'];
            if(!empty($search_value['value'])){
                foreach (self::columns as $item){
                    ($i==0) ? $dt_kasirDetail->where($item,'like', '%'.$search_value['value'].'%') : $dt_kasirDetail->orWhere($item,'like', '%'.$search_value['value'].'%');
                    $i++;
                }
            }

            $order_column = $input['order'];
            if($order_column[0]['column'] != 0){
                $dt_kasirDetail->orderBy(self::columns[($order_column[0]['column']-1)], $order_column['0']['dir']);
            } 
            else if(isset($input['order'])){
                $order = self::order;
                $dt_kasirDetail->orderBy(key($order), $order[key($order)]);
            }
            if ($type!='raw') {
                $length = $input['length'];
                if($length !== false){
                    if($length != -1) {
                        $dt_kasirDetail->offset($input['start']);
                        $dt_kasirDetail->limit($input['length']);
                    }
                }
            }
        }
        if ($type=='raw' || $type=='total') {
            $dt_kasirDetail = $dt_kasirDetail->count();
        }else{
            $dt_kasirDetail = $dt_kasirDetail->get();
        }
        return $dt_kasirDetail;
    }
    public static function getID($trans_stok_id){
    	$kasir = DB::table('trans_stok_detail')
    		->selectRaw('max(id) as id_detail')
    		->where('trans_stok_id',$trans_stok_id)->first();
    	if($kasir->id_detail > 0){
    		return sprintf('%05d', ($kasir->id_detail+1));
    	}
    	return sprintf('%05d', 1);
    }
}
