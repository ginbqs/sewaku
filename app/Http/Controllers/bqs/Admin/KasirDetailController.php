<?php

namespace App\Http\Controllers\bqs\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
Use View;
Use DB;

use App\Models\KasirDetail;
use App\Models\Kasir;

class KasirDetailController extends Controller
{
    function destroy(Request $request, $id){
    	if($request->ajax()){
    		DB::beginTransaction();

			try {
			    $id = explode("__", $id);
	    		$kasir = KasirDetail::where('id',$id[1])->where('trans_stok_id',$id[0]);
				$kasir->delete();
			    DB::commit();
	        	return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);

			    // all good
			} catch (\Exception $e) {
			    DB::rollback();
			    // something went wrong
				return response()->json(['type' => 'error', 'message' => "Silahkan cek koneksi Anda"]);
			}
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
}
