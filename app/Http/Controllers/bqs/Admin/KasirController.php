<?php

namespace App\Http\Controllers\bqs\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
Use View;
Use DB;

use App\Models\Kasir;
use App\Models\KasirDetail;
use App\Models\Barang;

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
			$date1 = date('m/d/Y',strtotime($kasir->tanggal_kembali));
			$date2 = date('m/d/Y',strtotime($kasir->tanggal_dikembalikan));
			$days = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24);

			$totalPembayaran = $kasir->total_bayar + $kasir->total_denda;

            $no++;
            $row = array();
        	$row[] = $no;
            $row[] = $kasir->peminjam;
            $row[] = 'Tgl Pinjam : '.date("d-m-Y",strtotime($kasir->tanggal_pinjam)).'<br>Tgl Harus Dikembalikan : '.date("d-m-Y",strtotime($kasir->tanggal_kembali)).'<br>Tgl Dikembalikan : '.date("d-m-Y",strtotime($kasir->tanggal_dikembalikan)).'<br>Telat : '.$days.' Hari';
            $row[] = KasirDetail::getBarangPinjam($kasir->id);
            $row[] = 'Bayar : Rp. '.number_format($kasir->total_bayar).'<br>Denda : '.number_format($kasir->total_denda).'<br>Total Pembayaran : Rp. '.number_format($totalPembayaran).'<br>Dibayar : Rp. '.number_format($kasir->total_uang).'<br>Kembalian : Rp. '.number_format($kasir->total_kembali);
            $row[] = strtoupper($kasir->status);
            $row[] = "<a data-toggle='tooltip' class='col-md-3 btn btn-warning btn-md edit' id='".$kasir->id."' title='Edit'> <i class='fa fa-edit text-error'></i></a> <a data-toggle='tooltip' class='col-md-3 btn btn-danger btn-md  ".($kasir->status=='kembali' ? '' : 'delete')."' id='".$kasir->id."' title='Delete'> <i class='fa fa-trash-alt'></i></a>";

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
				'input_pinjam'			=> 'required',
				'input_harus_dikembalikan'=> 'required',
				'input_peminjam' 		=> 'required',
				'input_peminjam_id'		=> 'required',
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
					    'tanggal_pinjam'=> date("Y-m-d",strtotime($request->input('input_pinjam'))),
					    'tanggal_kembali'=> date("Y-m-d",strtotime($request->input('input_harus_dikembalikan'))),
					    'status'		=> 'draft',
					    'user_id'		=> $request->input('input_peminjam_id'),
					    'peminjam'		=> $request->input('input_peminjam'),
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
    		$kasir = KasirDetail::where('trans_stok_id',$id)->get();
    		foreach ($kasir as $key) {
    			$barang = Barang::find($key->barang_id);
    			$barang->jumlah = $barang->jumlah + $key->jumlah;
    			$barang->save();
    		}
    		$kasir = KasirDetail::where('trans_stok_id',$id);
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
			    'trans_stok_id'  => $id[1],
			];
    		$view = View::make('bqs.kasir.editProduk',compact(['produk', 'kasir']))->render();
    		return response()->json(['html' => $view]);
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
				'trans_stok_id'				=> 'required',
				'input_nama_barang'			=> 'required',
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
							$produk 	= Barang::where('id',$idProduk[4])->first();
							$cekKasirDuplicate = KasirDetail::where('barang_id',$idProduk[4])->where('trans_stok_id',$input['trans_stok_id']);
							$idDetail   = KasirDetail::getID($input['trans_stok_id']);
							if (!$cekKasirDuplicate->exists()) {
									KasirDetail::create([
										'id'			=> $idDetail,
									    'trans_stok_id'	=> $input['trans_stok_id'],
									    'barang_id'		=> $idProduk[4],
									    'nama_barang'	=> $input['input_nama_barang'],
									    'jumlah'		=> $value,
									    'keterangan'	=> $input['input_keterangan'],
									]);
							}else{
				    			DB::commit();
								return response()->json(['type' => 'error', 'message' => "Data Sudah pernah di masukan. Silahkan edit di Tab Data Stok Opname"]);
							}
						}
					}
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
    function updateKasirDetail(Request $request,$id){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_detail_action'		=> 'required',
				'trans_stok_id'				=> 'required',
				'input_nama_barang'			=> 'required',
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
							DB::table('trans_stok_detail')
				            ->where('id', $idBeli[0])
				            ->where('trans_stok_id', $idBeli[1])
				            ->update([
							    'nama_barang'	=> $input['input_nama_barang'],
							    'jumlah'		=> $value,
							    'keterangan'	=> $input['input_keterangan'],
				            ]);
						}
					}
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
        $trans_stok_id = isset($input['trans_stok_id']) ? $input['trans_stok_id'] : 0;
        $dtKasir = Kasir::find($trans_stok_id);
        $data = array();
        foreach($dt_kasirDetail as $kasirDetail){
            $no++;
            $row = array();
        	$row[] = $no;
            $row[] = $kasirDetail->nama_barang;
            $row[] = $kasirDetail->jumlah;
            $row[] = $kasirDetail->keterangan;
            if ($dtKasir->status=='draft') {
            	$row[] = "<a data-toggle='tooltip' class='col-md-3 btn btn-warning btn-md edit' id='".$kasirDetail->trans_stok_id.'__'.$kasirDetail->id."' title='Edit'> <i class='fa fa-edit text-error'></i></a> <a data-toggle='tooltip' class='col-md-3 btn btn-danger btn-md  delete' id='".$kasirDetail->trans_stok_id.'__'.$kasirDetail->id."' title='Delete'> <i class='fa fa-trash-alt'></i></a>";
            }else{
            	$row[] = "<a data-toggle='tooltip' class='col-md-12 btn btn-danger btn-md' title='Terkunci' style='padding:20px'> <i class='fa fa-lock text-error'></i> Terkunci</a>";
            }

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
    		->select('trans_stok_detail.*','mst_barang.gambar','mst_barang.nama','mst_barang.kategori','mst_barang.jumlah as stok')
    		->join('mst_barang','mst_barang.id','=','trans_stok_detail.barang_id')
            ->where('trans_stok_detail.id', $id[1])
            ->where('trans_stok_detail.trans_stok_id', $id[0])
            ->first();
    		$view = View::make('bqs.kasir.editKasir',compact(['produk']))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
	function kembalikan(Request $request,$kasir_id){
    	if ($request->ajax()) {
    		DB::beginTransaction();

			try {
			    $input = $request->all();
			    $kasirDetail = KasirDetail::where('trans_stok_id',$kasir_id)->get();
			    foreach ($kasirDetail as $key) {
			    	$barang = Barang::where('id',$key->barang_id)->first();
					$barang->jumlah = $barang->jumlah + $key->jumlah;
					$barang->save();
			    }
	    		DB::table('trans_stok')
	            ->where('id', $kasir_id)
	            ->update([
	            	'status' => 'kembali',
	            	'tanggal_dikembalikan' => date("Y-m-d",strtotime($input['input_dikembalikan'])),
	            	'hari_telat' => $input['input_hari_telat']!='' ? $input['input_hari_telat'] : NULL,
	            	'total_bayar' => $input['input_total_bayar'] !='' ? $input['input_total_bayar'] : NULL,
	            	'total_denda' => $input['input_total_denda'] !='' ? $input['input_total_denda'] : NULL,
	            	'hari_telat' => $input['input_hari_telat'] !='' ? $input['input_hari_telat'] : NULL,
	            	'total_uang' => $input['input_total_terima_uang'] !='' ? $input['input_total_terima_uang'] : NULL,
	            	'total_kembali' => $input['input_total_kembali'] !='' ? $input['input_total_kembali'] : NULL,
	            ]);
			    DB::commit();
				return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);

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
    function selesai(Request $request,$kasir_id){
    	if ($request->ajax()) {
    		DB::beginTransaction();

			try {
			    $input = $request->all();
			    $kasirDetail = KasirDetail::where('trans_stok_id',$kasir_id)->get();
			    foreach ($kasirDetail as $key) {
			    	$barang = Barang::where('id',$key->barang_id)->first();
					$barang->jumlah = $barang->jumlah - $key->jumlah;
					$barang->save();
			    }
	    		DB::table('trans_stok')
	            ->where('id', $kasir_id)
	            ->update([
	            	'status' => 'pinjam',
	            ]);
			    DB::commit();
				return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);

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
