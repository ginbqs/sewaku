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
				'input_name' 			=> 'required',
				'input_email' 			=> 'required',
				'input_phone_number' 	=> 'required',
				'input_password' 		=> 'required',
				'input_level' 			=> 'required',
				'input_level_id' 		=> 'required',
				'input_provinsi' 		=> 'required',
				'input_provinsi_id' 	=> 'required',
				'input_kota' 			=> 'required',
				'input_kota_id' 		=> 'required',
				'input_kecamatan' 		=> 'required',
				'input_kecamatan_id' 	=> 'required',
				'input_desa' 			=> 'required',
				'input_desa_id' 		=> 'required',
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
    			$id = IdGenerator::generate(['table' => 'app_user_list', 'length' => 15, 'prefix' =>$request->input('input_desa_id').'-']);
				User::create([
        			'id'			=> $id,
				    'name' 			=> strtoupper(strtolower($request->input('input_name'))),
				    'email' 		=> strtolower($request->input('input_email')),
		            'phone_number' 	=> $request->input('input_phone_number'),
		            'provinsi_id'	=> $request->input('input_provinsi_id'),
		            'kota_id' 		=> $request->input('input_kota_id'),
		            'kecamatan_id' 	=> $request->input('input_kecamatan_id'),
		            'desa_id' 		=> $request->input('input_desa_id'),
		            'alamat' 		=> $request->input('input_alamat'),
		            'status_konfirmasi' => '1',
		            'password' 		=> bcrypt($request->input('input_password')),
		            'app_user_level_id' => $request->input('input_level_id'),
				]);
				return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function edit(Request $request, $id){
    	if($request->ajax()){
    		$user = DB::table('app_user_list')
    		->leftJoin('mst_desa',  'mst_desa.id', '=', 'app_user_list.desa_id')
            ->leftJoin('mst_kecamatan',  'mst_kecamatan.id', '=', 'mst_desa.kecamatan_id')
            ->leftJoin('mst_kota',  'mst_kota.id', '=', 'mst_kecamatan.kota_id')
            ->leftJoin('mst_provinsi',  'mst_provinsi.id', '=', 'mst_kota.provinsi_id')
    	 	->join('app_user_level',  'app_user_level.level', '=', 'app_user_list.app_user_level_id')
            ->select('app_user_list.*', 'mst_provinsi.nama as mst_provinsi_nama', 'mst_kota.nama as mst_kota_nama', 'mst_kecamatan.nama as mst_kecamatan_nama','mst_desa.nama as mst_desa_nama','app_user_level.value as app_user_level_value')
            ->where('app_user_list.id', $id)
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
				'input_name' 			=> 'required',
				'input_email' 			=> 'required',
				'input_phone_number' 	=> 'required',
				'input_level' 			=> 'required',
				'input_level_id' 		=> 'required',
				'input_provinsi' 		=> 'required',
				'input_provinsi_id' 	=> 'required',
				'input_kota' 			=> 'required',
				'input_kota_id' 		=> 'required',
				'input_kecamatan' 		=> 'required',
				'input_kecamatan_id' 	=> 'required',
				'input_desa' 			=> 'required',
				'input_desa_id' 		=> 'required',
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$user = User::find($id);
				$user->name = strtoupper(strtolower($request->input_name));
				$user->email = strtolower($request->input_email);
				$user->phone_number = $request->input_phone_number;
				$user->app_user_level_id = strtolower($request->input_level_id);
				$user->provinsi_id 	= $request->input_provinsi_id;
				$user->kota_id 		= $request->input_kota_id;
				$user->kecamatan_id = $request->input_kecamatan_id;
				$user->desa_id 		= $request->input_desa_id;
				$user->alamat 		= $request->input_alamat;
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

        if($search == ''){
            $users = User::orderby('name','asc')->select('id','name')->limit(5);
        }else{
            $users = User::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(5);
        }
        if (isset($input['level']) && $input['level']!='') {
        	$users = $users->where('app_user_level_id',$input['level']);
        }
        $users = $users->get();
        $response = array();
        foreach($users as $user){
            $response[] = array("value"=>$user->id,"label"=>$user->name);
        }

        return response()->json($response);
    }
}
