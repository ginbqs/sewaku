<?php

namespace App\Http\Controllers\bqs\Admin\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
Use View;
Use DB;

class UserController extends Controller
{
    function index(){
    	return view('bqs.panel.user.all');
    }
    public function allUser(Request $request){
    	$input = $request->all();
    	$dt_user = User::getAllUser($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_user as $user){
            $no++;
            $row = array();
        	$row[] = $no;
            $row[] = $user->nama;
            $row[] = $user->user_level_value;
            $row[] = "<a data-toggle='tooltip' class='col-md-3 btn btn-warning btn-md edit' id='".$user->id."' title='Edit'> <i class='fa fa-edit text-error'></i></a> <a data-toggle='tooltip' class='col-md-3 btn btn-danger btn-md  delete' id='".$user->id."' title='Delete'> <i class='fa fa-trash-alt'></i></a>";

            $data[] = $row;
        }
        $output = array(
		            "draw" => $input['draw'],
		            "recordsTotal" =>  User::getAllUser($input,'total'),
		            "recordsFiltered" => User::getAllUser($input,'raw'),
		            "data" => $data,
		            );
		//output to json format
		echo json_encode($output);
    }
    function create(Request $request){
    	if ($request->ajax()) {
    		$view = View::make('bqs.panel.user.create',)->render();
    		return response()->json(['html' => $view]);
    	}else{
         	return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
    	}
    }
    function store(Request $request){
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_nama' 			=> 'required',
				'input_email' 			=> 'required',
				'input_password' 		=> 'required',
				'input_phone_number' 	=> 'required',
				'input_level' 			=> 'required',
				'input_level_id' 		=> 'required',
				'input_kelamin' 		=> 'required',
				'input_tempat_lahir' 	=> 'required',
				'input_tanggal_lahir'	=> 'required',
				'input_provinsi' 		=> 'required',
				'input_provinsi_id' 	=> 'required',
				'input_kota' 			=> 'required',
				'input_kota_id' 		=> 'required',
				'input_kecamatan' 		=> 'required',
				'input_kecamatan_id' 	=> 'required',
				'input_desa' 			=> 'required',
				'input_desa_id' 		=> 'required',
				'input_alamat' 			=> 'required',
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				if ($request->input('input_level_id')=='peminjam') {
					$id = 'S'.time();
				}else{
					$id = 'P'.time();
				}
				User::create([
        			'id'			=> $id,
				    'nama' 			=> strtoupper(strtolower($request->input('input_nama'))),
				    'email' 		=> strtolower($request->input('input_email')),
		            'password' 		=> bcrypt($request->input('input_password')),
		            'nis' 			=> $request->input('input_nis'),
		            'ktp' 			=> $request->input('input_nik'),
		            'jurusan' 		=> $request->input('input_jurusan'),
		            'kelamin' 		=> $request->input('input_kelamin'),
		            'agama' 		=> $request->input('input_agama'),
		            'tempat_lahir' 	=> $request->input('input_tempat_lahir'),
		            'tanggal_lahir' => date("Y-m-d",strtotime($request->input('input_tanggal_lahir'))),
		            'no_hp' 		=> $request->input('input_phone_number'),
		            'provinsi'		=> $request->input('input_provinsi_id'),
		            'kota' 			=> $request->input('input_kota_id'),
		            'kecamatan' 	=> $request->input('input_kecamatan_id'),
		            'desa' 			=> $request->input('input_desa_id'),
		            'alamat' 		=> $request->input('input_alamat'),
		            'user_level_id' => $request->input('input_level_id'),
				]);
				if ($request->input('input_foto')!='') {
					$input['image'] = $id.'.'.$request->input_foto->extension();
	        		if ($request->input_foto->move(public_path('images/users'), $input['image'])) {
	        			User::where('id',$id)
	        			->update(['foto' => 'images/users/'.$input['image']]);
						return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
	        		}else{
						return response()->json(['error'=>$validator->errors()->all()]);
	        		}
				}
				return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function edit(Request $request, $id){
    	if($request->ajax()){
    		$user = DB::table('users')
    	 	->join('users_level',  'users_level.level', '=', 'users.user_level_id')
            ->select('users.*','users_level.value as user_level_value')
            ->where('users.id', $id)
            ->first();
    		$view = View::make('bqs.panel.user.edit',compact('user'))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }

    function update(Request $request, $id){
    	if($request->ajax()){
    		$rules = [
				'input_nama' 			=> 'required',
				'input_email' 			=> 'required',
				'input_phone_number' 	=> 'required',
				'input_level' 			=> 'required',
				'input_level_id' 		=> 'required',
				'input_kelamin' 		=> 'required',
				'input_tempat_lahir' 	=> 'required',
				'input_tanggal_lahir'	=> 'required',
				'input_provinsi' 		=> 'required',
				'input_provinsi_id' 	=> 'required',
				'input_kota' 			=> 'required',
				'input_kota_id' 		=> 'required',
				'input_kecamatan' 		=> 'required',
				'input_kecamatan_id' 	=> 'required',
				'input_desa' 			=> 'required',
				'input_desa_id' 		=> 'required',
				'input_alamat' 			=> 'required',
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$user = User::find($id);
				if ($request->input_foto!='') {
					if ($user->foto!='') {
						if(file_exists(public_path('images/users/'.$user->foto))){
					    	unlink(public_path('images/users/'.$user->foto));
					    }
					}
				    $input['image'] = $id.'.'.$request->input_foto->extension();
		    		$request->input_foto->move(public_path('images/users'), $input['image']);
					$user->foto 		= 'images/users/'.$input['image'];
			    }
				$user->nama 		= strtoupper(strtolower($request->input_nama));
				$user->email 		= strtolower($request->input_email);
				$user->nis 			= $request->input_nis;
				$user->ktp 			= $request->input_nik;
				$user->jurusan 		= $request->input_jurusan;
				$user->kelamin 		= $request->input_kelamin;
				$user->agama 		= $request->input_agama;
				$user->tempat_lahir = $request->input_tempat_lahir;
				$user->tanggal_lahir= date("Y-m-d",strtotime($request->input_tanggal_lahir));
				$user->no_hp 		= $request->input_phone_number;
				$user->provinsi 	= $request->input_provinsi_id;
				$user->kota 		= $request->input_kota_id;
				$user->kecamatan 	= $request->input_kecamatan_id;
				$user->desa 		= $request->input_desa_id;
				$user->alamat 		= $request->input_alamat;
				$user->user_level_id = strtolower($request->input_level_id);
				$user->save();

            	return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
			}
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function destroy(Request $request, $id){
    	if($request->ajax()){
			$user = User::find($id);
			$user->delete();
        	return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    public function autocomplete(Request $request)
    {
    	$input 	= $request->all();
        $search = $request->input('search');
        $table = $request->input('table');

        if($search == ''){
            $users = User::orderby($table,'asc')->select($table)->limit(5);
        }else{
            $users = User::orderby($table,'asc')->select($table)->where($table, 'like', '%' .$search . '%')->groupBy($table)->limit(5);
        }
        if (isset($input['level']) && $input['level']!='') {
        	$users = $users->where('app_user_level_id',$input['level']);
        }
        $users = $users->get();
        $response = array();
        foreach($users as $user){
        	if (isset($input['level']) && $input['level']!='') {
            	$response[] = array("value"=>$user->id,"label"=>$user->name);
	        }else{
            	$response[] = array("value"=>$user->$table,"label"=>$user->$table);
	        }
        }

        return response()->json($response);
    }
    public function autocompleteUser(Request $request)
    {
    	$input 	= $request->all();
        $search = $request->input('search');

        if($search == ''){
            $users = User::orderby('nama','asc')->select($table)->where('user_level_id','peminjam')->limit(5);
        }else{
            $users = User::orderby('nama','asc')->select('users.*')->where('nama', 'like', '%' .$search . '%')->where('user_level_id','peminjam')->limit(5);
        }
        $users = $users->get();
        $response = array();
        foreach($users as $user){
            $response[] = array("value"=>$user->id,"label"=>$user->nama);
        }

        return response()->json($response);
    }
}
