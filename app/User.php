<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nama',
        'email',
        'password',
        'nis',
        'ktp',
        'jurusan',
        'kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'provinsi',
        'kota',
        'kecamatan',
        'desa',
        'alamat',
        'foto',
        'user_level_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const order = ['users.nama' => 'ASC'];
    const columns = ['users.nama','users_level.value'];

    public static function getAllUser($input,$type='row'){
        $dt_user = DB::table('users')
            ->join('users_level',  'users_level.level', '=', 'users.user_level_id')
             ->select('users.*', 'users_level.value as user_level_value', DB::raw('@rownum:= @rownum +1 As rownum'));
        if ($type!='total') {
            $i = 0;
            $search_value = $input['search'];
            if(!empty($search_value['value'])){
                foreach (self::columns as $item){
                    ($i==0) ? $dt_user->where($item,'like', '%'.$search_value['value'].'%') : $dt_user->orWhere($item,'like', '%'.$search_value['value'].'%');
                    $i++;
                }
            }

            $order_column = $input['order'];
            if($order_column[0]['column'] != 0){
                $dt_user->orderBy(self::columns[($order_column[0]['column']-1)], $order_column['0']['dir']);
            } 
            else if(isset($input['order'])){
                $order = self::order;
                $dt_user->orderBy(key($order), $order[key($order)]);
            }
            if ($type!='raw') {
                $length = $input['length'];
                if($length !== false){
                    if($length != -1) {
                        $dt_user->offset($input['start']);
                        $dt_user->limit($input['length']);
                    }
                }
            }
        }
        if ($type=='raw' || $type=='total') {
            $dt_user = $dt_user->count();
        }else{
            $dt_user = $dt_user->get();
        }
        
        return $dt_user;
    }
}
