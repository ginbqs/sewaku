<?php

namespace App\Http\Controllers\bqs\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
Use View;
Use DB;

use App\Models\Kasir;
use App\Models\Barang;
use App\Models\KasirDetail;

class KasirController extends Controller
{
    function index(){
    	return view('bqs.kasir.all');
    }
    public function allKasir(Request $request){
    	$input = $request->all();
    	$dt_kasir = Kasir::getAllKasir($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_kasir as $kasir){
            $no++;
            $row = array();
        	$row[] = $no;
            $row[] = date("Y-m-d",strtotime($kasir->tanggal));
            $row[] = $kasir->total_nilai;
            $row[] = $kasir->keterangan;
            $row[] = "<a data-toggle='tooltip' class='col-md-3 btn btn-warning btn-md edit' id='".$kasir->id."' title='Edit'> <i class='fa fa-edit text-error'></i></a> <a data-toggle='tooltip' class='col-md-3 btn btn-danger btn-md  ".($kasir->status=='1' ? '' : 'delete')."' id='".$kasir->id."' title='Delete'> <i class='fa fa-trash-alt'></i></a>";

            $data[] = $row;
        }
        $output = array(
		            "draw" => $input['draw'],
		            "recordsTotal" =>  Kasir::getAllKasir($input,'total'),
		            "recordsFiltered" => Kasir::getAllKasir($input,'raw'),
		            "data" => $data,
		            );
		//output to json format
		echo json_encode($output);
    }
    function create(Request $request){
    	return view('bqs.kasir.create',['act' => 'add']);
    }
    function edit(Request $request, $id){
		$kasir = DB::table('trans_stok')
        ->select('trans_stok.*')
        ->where('trans_stok.id', $id)
        ->first();
        // dd($kasir);
    	return view('bqs.kasir.edit',compact('kasir'))->with(['act'=>'edit']);
    }
    function update(Request $request,$id){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_action'			=> 'required',
				'input_tgl_kasir'	=> 'required',
				'input_keterangan' 		=> 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
					'type' => 'error',
					'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				if ($request->input_action=='add') {
					$id = time();
					Kasir::create([
						'id'			=> $id,
					    'tanggal'		=> date("Y-m-d",strtotime($request->input('input_tgl_kasir'))),
					    'total_nilai'	=> 0,
					    'total_item'	=> 0,
					    'keterangan'	=> $request->input('input_keterangan'),
					    'user_id'		=> $dt_auth->id,
					    'status'		=> 0,
					]);
					
					return response()->json(['type' => 'success', 'message' => "Successfully Created", 'id' => $id]);
				}else{
					$kasir = Kasir::find($id);
					$kasir->tanggal 	= date("Y-m-d",strtotime($request->input('input_tgl_kasir')));
					$kasir->keterangan 	= $request->input('input_keterangan');
					$kasir->user_id 		= $dt_auth->id;
					$kasir->save();
	            	return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
				}
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function destroy(Request $request, $id){
    	if($request->ajax()){
    		$kasir = KasirDetail::where('id',$id);
			$kasir->delete();

    		$kasir = Kasir::find($id);
			$kasir->delete();
        	return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function editProduk(Request $request, $id){
    	if($request->ajax()){
    		$id = explode("__", $id);
    		$produk = DB::table('mst_barang')
            ->select('mst_barang.*')
            ->where('mst_barang.id', $id[0])
            ->first();
            $kasir = (object)[
			    'id'  => $id[1],
			];
    		$view = View::make('bqs.kasir.editProduk',compact(['produk', 'kasir']))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }

    function getValidateVarian(Request $request,$id){
    	if($request->ajax()){
    		$has_history = DB::table('histori_produk')->select('id')
            ->where('histori_produk.produk_id', $id)
            ->exists();
            $produk = Produk::find($id);
            $response['has_history'] 	= $has_history;
            $response['child'] 			= Produk::hasChild($id)->get();
            $response['stok'] 			= $produk->stok;
    		return json_encode($response);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function createKasirDetail(Request $request){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_detail_action'		=> 'required',
				'id'				=> 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
					'type' => 'error',
					'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				DB::beginTransaction();

				try {
				    $input = $request->all();
					$id = 'M'.time();
					foreach ($input as $key => $value) {
						if (substr($key, 0,25)=='input_jumlah_beli_produk_') {
							$idProduk 	= explode('_', $key);
							$produk 	= Produk::where('id',$idProduk[4])->first();
							$idDetail   = KasirDetail::getID($input['id']);
							$hasChild 	= Produk::hasChild($idProduk[4])->exists();
							$cekKasirDuplicate = KasirDetail::where('produk_id',$idProduk[4])->where('id',$input['id']);
							if (!$hasChild) {
								if (!$cekKasirDuplicate->exists()) {
										KasirDetail::create([
											'id'			=> $idDetail,
										    'id'=> $input['id'],
										    'produk_id'		=> $idProduk[4],
										    'jumlah'		=> $produk->stok,
										    'jumlah_fisik'	=> $value,
										    'selisih'		=> $value - $produk->stok,
										    'harga'			=> $produk->harga_jual,
										    'keterangan'	=> '-',
										]);
								}else{
									self::UpdateNilai($input['id']);
					    			DB::commit();
									return response()->json(['type' => 'error', 'message' => "Data Sudah pernah di masukan. Silahkan edit di Tab Data Stok Opname"]);
								}
							}
						}
					}
					self::UpdateNilai($input['id']);
				    DB::commit();
					return response()->json(['type' => 'success', 'message' => "Successfully Created", 'id' => $id]);

				    // all good
				} catch (\Exception $e) {
				    DB::rollback();
				    dd($e);
					return response()->json(['type' => 'error', 'message' => "Silahkan cek koneksi Anda"]);
				    // something went wrong
				}
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function updateKasirDetail(Request $request,$id){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_detail_action'		=> 'required',
				'id'				=> 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
					'type' => 'error',
					'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				DB::beginTransaction();

				try {
				    $input = $request->all();
					$idBeli = explode("__", $id);
					foreach ($input as $key => $value) {
						if (substr($key, 0,25)=='input_jumlah_beli_produk_') {
							$idProduk 	= explode('_', $key);
							$produk 	= Produk::where('id',$idProduk[4])->first();
							$idDetail   = KasirDetail::getID($input['id']);
							$hasChild 	= Produk::hasChild($idProduk[4])->exists();

							if (!$hasChild) {
								DB::table('trans_stok_detail')
					            ->where('id', $idBeli[0])
					            ->where('id', $idBeli[1])
					            ->update([
								    'jumlah'		=> $produk->stok,
								    'jumlah_fisik'	=> $value,
								    'selisih'		=> $value - $produk->stok,
								    'harga'			=> $produk->harga_jual,
								    'keterangan'	=> '-',
					            ]);
				        	}
						}
					}
					self::UpdateNilai($input['id']);
				    DB::commit();
					return response()->json(['type' => 'success', 'message' => "Successfully Created", 'id' => $id]);

				    // all good
				} catch (\Exception $e) {
				    DB::rollback();
					return response()->json(['type' => 'error', 'message' => "Silahkan cek koneksi Anda"]);
				    // something went wrong
				}
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    public function AllKasirDetail(Request $request){
    	$input = $request->all();
    	$dt_kasirDetail = KasirDetail::getAllKasirDetail($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_kasirDetail as $kasirDetail){
            $no++;
            $row = array();
        	$row[] = $no;
            $row[] = $kasirDetail->mst_barang_nama;
            $row[] = "<div class='row'><div class='col-6'>Stok</div><div class='col-6'>: ".$kasirDetail->jumlah.' '.$kasirDetail->mst_satuan_nama."</div><div class='col-6'>Opname Fisik</div><div class='col-6'>: ".$kasirDetail->jumlah_fisik.' '.$kasirDetail->mst_satuan_nama."</div><div class='col-6'>Selisih</div><div class='col-6'>: ".$kasirDetail->selisih.' '.$kasirDetail->mst_satuan_nama."</div></div>";
            $row[] = "<a data-toggle='tooltip' class='col-md-3 btn btn-warning btn-md edit' id='".$kasirDetail->id.'__'.$kasirDetail->id."' title='Edit'> <i class='fa fa-edit text-error'></i></a> <a data-toggle='tooltip' class='col-md-3 btn btn-danger btn-md  delete' id='".$kasirDetail->id.'__'.$kasirDetail->id."' title='Delete'> <i class='fa fa-trash-alt'></i></a>";

            $data[] = $row;
        }
        $output = array(
		            "draw" => $input['draw'],
		            "recordsTotal" =>  KasirDetail::getAllKasirDetail($input,'total'),
		            "recordsFiltered" => KasirDetail::getAllKasirDetail($input,'raw'),
		            "data" => $data,
		            );
		//output to json format
		echo json_encode($output);
    }
    function editKasir(Request $request, $id){
    	if($request->ajax()){
    		$id = explode("__", $id);
    		$produk = DB::table('trans_stok_detail')
    		->join('mst_barang',  'mst_barang.id', '=', 'trans_stok_detail.produk_id')
            ->select('trans_stok_detail.*','mst_barang.nama','mst_barang.foto','mst_barang.stok','mst_barang.stok_min','mst_barang.is_expire','mst_barang.tgl_kadaluarsa','mst_barang.harga_beli','mst_barang.harga_jual')
            ->where('trans_stok_detail.id', $id[1])
            ->where('trans_stok_detail.id', $id[0])
            ->first();
    		$view = View::make('bqs.kasir.editKasir',compact(['produk']))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function getNilai(Request $request,$kasir_id){
		if ($request->ajax()) {
    		$kasir = Kasir::select('total_nilai','total_item')->where('id',$kasir_id)->first();
			return response()->json(['total_nilai' =>number_format($kasir->total_nilai,2),'total_item' => $kasir->total_item]);
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function UpdateNilai($kasir_id){
			$kasir = KasirDetail::select(DB::raw('sum(jumlah) as total_item'),DB::raw('sum(jumlah*harga) as total_nilai'))->where('id',$kasir_id)->first();
			DB::table('trans_stok')
            ->where('id', $kasir_id)
            ->update([
            	'total_nilai' => $kasir->total_nilai > 0 ? $kasir->total_nilai : 0,
            	'total_item' => $kasir->total_item > 0 ? $kasir->total_item : 0,
            ]);
    }
    function selesai(Request $request,$kasir_id){
    	if ($request->ajax()) {
    		DB::beginTransaction();

			try {
    			$dt_auth 	= Auth::user();
			    $input = $request->all();
			    $kasirDetail = KasirDetail::where('id',$kasir_id)->get();
			    foreach ($kasirDetail as $key) {
			    	$produk = Produk::where('id',$key->produk_id)->first();
					$produk->stok = (int)$key->jumlah_fisik;
					$produk->save();
					if ($produk->sub_id!='') {
						Produk::updateStok($produk->sub_id);
					}
			    }
	    		DB::table('trans_stok')
	            ->where('id', $kasir_id)
	            ->update([
	            	'status' => '1',
	            ]);
			    DB::commit();
				return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);

			    // all good
			} catch (\Exception $e) {
			    DB::rollback();
			    dd($e);
			    // something went wrong
				return response()->json(['type' => 'error', 'message' => "Silahkan cek koneksi Anda"]);
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
}
