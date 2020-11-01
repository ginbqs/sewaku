<?php

namespace App\Models\Panel;

use Illuminate\Database\Eloquent\Model;
use DB;

class Config extends Model
{
    protected $table = 'app_config';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'id','value'
    ];
     const order = ['value' => 'ASC'];
    const columns = ['value','id'];

    public static function getAllConfig($input,$type='row'){
        $dt_config = DB::table('app_config')
            ->select('app_config.*');
        if ($type!='total') {
            $i = 0;
            $search_value = $input['search'];
            if(!empty($search_value['value'])){
                foreach (self::columns as $item){
                    ($i==0) ? $dt_config->where($item,'like', '%'.$search_value['value'].'%') : $dt_config->orWhere($item,'like', '%'.$search_value['value'].'%');
                    $i++;
                }
            }

            $order_column = $input['order'];
            if($order_column[0]['column'] != 0){
                $dt_config->orderBy(self::columns[($order_column[0]['column']-1)], $order_column['0']['dir']);
            } 
            else if(isset($input['order'])){
                $order = self::order;
                $dt_config->orderBy(key($order), $order[key($order)]);
            }
            if ($type!='raw') {
                $length = $input['length'];
                if($length !== false){
                    if($length != -1) {
                        $dt_config->offset($input['start']);
                        $dt_config->limit($input['length']);
                    }
                }
            }
        }
        if ($type=='raw' || $type=='total') {
            $dt_config = $dt_config->count();
        }else{
            $dt_config = $dt_config->get();
        }
        
        return $dt_config;
    }
}
