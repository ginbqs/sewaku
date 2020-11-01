<?php

namespace App\Http\Controllers\bqs\Admin\Panel;;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Panel\Level;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
Use View;
Use DB;

class LevelController extends Controller
{
    function index(){
    	return view('bqs.panel.level.all');
    }
    public function allLevel(Request $request){
    	$input = $request->all();
        $dt_level = Level::getAllLevel($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_level as $level){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $level->level;
            $row[] = $level->value;
            $row[] = "<a data-toggle='tooltip' class='col-md-3 btn btn-warning btn-md edit' id='".$level->level."' title='Edit'> <i class='fa fa-edit text-error'></i></a> <a data-toggle='tooltip' class='col-md-3 btn btn-danger btn-md  delete' id='".$level->level."' title='Delete'> <i class='fa fa-trash-alt'></i></a>";

            $data[] = $row;
        }
        $output = array(
                    "draw" => $input['draw'],
                    "recordsTotal" =>  Level::getAllLevel($input,'total'),
                    "recordsFiltered" => Level::getAllLevel($input,'raw'),
                    "data" => $data,
                    );
        //output to json format
        echo json_encode($output);
    }
    function create(Request $request){
    	if ($request->ajax()) {
    		$view = View::make('bqs.panel.level.create',)->render();
    		return response()->json(['html' => $view]);
    	}else{
         	return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
    	}
    }
    function store(Request $request){
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_level' 	=> 'required',
				'input_value' 	=> 'required',
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				Level::create([
					'level'		=> strtolower($request->input('input_level')),
				    'value' 	=> strtoupper(strtolower($request->input('input_value'))),
				]);
				return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function edit(Request $request, $id){
    	if($request->ajax()){
    		$level = DB::table('users_level')
            ->where('users_level.level', $id)
            ->first();
    		$view = View::make('bqs.panel.level.edit',compact('level'))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }

    function update(Request $request, $id){
    	if($request->ajax()){
    		$rules = [
				'input_level' 	=> 'required',
				'input_value' 	=> 'required',
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$level = Level::find($id);
				$level->value = strtoupper(strtolower($request->input_value));
				$level->save();
            	return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
			}
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function destroy(Request $request, $id){
    	if($request->ajax()){
    		$level = Level::where('xlevel',$id)->first();
			$level->delete();
        	return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    public function autocomplete(Request $request)
    {
        $search = $request->input('search');

        if($search == ''){
            $levels = Level::orderby('value','asc')->select('level','value')->limit(5)->get();
        }else{
            $levels = Level::orderby('value','asc')->select('level','value')->where('value', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($levels as $level){
            $response[] = array("value"=>$level->level,"label"=>$level->value);
        }

        return response()->json($response);
    }
}
