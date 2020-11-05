<?php

namespace App\Http\Controllers\Backend\Admin;

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
	    		$kasir = KasirDetail::where('id',$id[1])->where('id',$id[0]);
				$kasir->delete();

	    		$kasir = KasirDetail::select(DB::raw('sum(jumlah) as total_item'),DB::raw('sum(jumlah*harga) as total_nilai'))
	    		->where('id',$id[1])->first();
				 DB::table('trans_stok')
	                ->where('id', $id[1])
	                ->update([
	                	'total_nilai' => $kasir->total_nilai > 0 ? $kasir->total_nilai : 0,
	                	'total_item' => $kasir->total_item > 0 ? $kasir->total_item : 0,
	                ]);
			    DB::commit();
	        	return response()->json(['type' => 'success', 'message' => "Successfully Deleted", 'total_nilai' => number_format($kasir->total_nilai), 'total_item' => $kasir->total_item]);

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
