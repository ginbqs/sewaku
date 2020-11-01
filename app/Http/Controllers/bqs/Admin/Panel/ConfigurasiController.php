<?php

namespace App\Http\Controllers\bqs\Admin\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Panel\Config;
use Illuminate\Support\Facades\Validator;
Use View;
Use DB;

class ConfigurasiController extends Controller
{
    function index(){
    	return view('bqs.panel.config.all');
    }
    public function allConfig(Request $request){
    	$input = $request->all();
        $dt_config = Config::getAllConfig($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_config as $config){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $config->id;
            $row[] = $config->value;
            $row[] = "<a data-toggle='tooltip' class='col-md-3 btn btn-warning btn-md edit' id='".$config->id."' title='Edit'> <i class='fa fa-edit text-error'></i></a> <a data-toggle='tooltip' class='col-md-3 btn btn-danger btn-md  delete' id='".$config->id."' title='Delete'> <i class='fa fa-trash-alt'></i></a>";

            $data[] = $row;
        }
        $output = array(
                    "draw" => $input['draw'],
                    "recordsTotal" =>  Config::getAllConfig($input,'total'),
                    "recordsFiltered" => Config::getAllConfig($input,'raw'),
                    "data" => $data,
                    );
        //output to json format
        echo json_encode($output);
    }
    function create(Request $request){
    	if ($request->ajax()) {
    		$view = View::make('bqs.panel.config.create',)->render();
    		return response()->json(['html' => $view]);
    	}else{
         	return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
    	}
    }
    function store(Request $request){
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_id' 	=> 'required',
				'input_value' 	=> 'required',
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				Config::create([
					'id'		=> strtolower($request->input('input_id')),
				    'value' 	=> (strtolower($request->input('input_value'))),
				]);
				return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function edit(Request $request, $id){
    	if($request->ajax()){
    		$configurasi = DB::table('app_config')
            ->where('app_config.id', $id)
            ->first();
    		$view = View::make('bqs.panel.config.edit',compact('configurasi'))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }

    function update(Request $request, $id){
    	if($request->ajax()){
    		$rules = [
				'input_id' 	=> 'required',
				'input_value' 	=> 'required',
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$config = Config::find($id);
				$config->value = (strtolower($request->input_value));
				$config->save();
            	return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
			}
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function destroy(Request $request, $id){
    	if($request->ajax()){
    		$config = Config::find($id);
			$config->delete();
        	return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    public function autocomplete(Request $request)
    {
        $search = $request->input('search');

        if($search == ''){
            $configs = Config::orderby('value','asc')->select('id','value')->limit(5)->get();
        }else{
            $configs = Config::orderby('value','asc')->select('id','value')->where('value', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($configs as $config){
            $response[] = array("value"=>$config->id,"label"=>$config->value);
        }

        return response()->json($response);
    }
}
