<?php

namespace App\Models\Panel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Level extends Model
{
    use SoftDeletes;
    protected $table = 'users_level';
    protected $primaryKey = 'level';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'level', 'value'
    ];
    const order = ['level' => 'ASC'];
    const columns = ['level','value'];
    
    public static function getAllLevel($input,$type='row'){
        $dt_level = DB::table('users_level')
            ->select('users_level.*')
            ->whereNull('deleted_at');
        if ($type!='total') {
            $i = 0;
            $search_value = $input['search'];
            if(!empty($search_value['value'])){
                foreach (self::columns as $item){
                    ($i==0) ? $dt_level->where($item,'like', '%'.$search_value['value'].'%') : $dt_level->orWhere($item,'like', '%'.$search_value['value'].'%');
                    $i++;
                }
            }

            $order_column = $input['order'];
            if($order_column[0]['column'] != 0){
                $dt_level->orderBy(self::columns[($order_column[0]['column']-1)], $order_column['0']['dir']);
            } 
            else if(isset($input['order'])){
                $order = self::order;
                $dt_level->orderBy(key($order), $order[key($order)]);
            }
            if ($type!='raw') {
                $length = $input['length'];
                if($length !== false){
                    if($length != -1) {
                        $dt_level->offset($input['start']);
                        $dt_level->limit($input['length']);
                    }
                }
            }
        }
        if ($type=='raw' || $type=='total') {
            $dt_level = $dt_level->count();
        }else{
            $dt_level = $dt_level->get();
        }
        
        return $dt_level;
    }
}
