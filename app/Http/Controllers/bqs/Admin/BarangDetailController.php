<?php

namespace App\Http\Controllers\bqs\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Ramsey\Uuid\Uuid;
use App\Models\ProdukDetail;
use App\Models\Produk;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
Use View;
Use DB;

class ProdukDetailController extends Controller
{
    public function allProdukDetail(Request $request){
    	$input = $request->all();
    	$dt_produkDetail = ProdukDetail::getAllProdukDetail($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_produkDetail as $produkDetail){
            $no++;
            $row = array();
        	$row[] = $no;
            $row[] = $produkDetail->nama;
            $row[] = $produkDetail->mst_bahan_jenis_nama;
            $row[] = $produkDetail->stok;
            $row[] = $produkDetail->harga_jual;
            $row[] = "<a data-toggle='tooltip' class='col-md-3 btn btn-warning btn-md edit' id='".$produkDetail->id."' title='Edit'> <i class='fa fa-edit text-error'></i></a> <a data-toggle='tooltip' class='col-md-3 btn btn-danger btn-md  delete' id='".$produkDetail->id."' title='Delete'> <i class='fa fa-trash-alt'></i></a>";

            $data[] = $row;
        }
        $output = array(
		            "draw" => $input['draw'],
		            "recordsTotal" =>  ProdukDetail::getAllProdukDetail($input,'total'),
		            "recordsFiltered" => ProdukDetail::getAllProdukDetail($input,'raw'),
		            "data" => $data,
		            );
		//output to json format
		echo json_encode($output);
    }
    function store(Request $request){
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_detail_nama' 	=> 'required',
				'input_detail_action' 	=> 'required',
				'input_detail_stok' 	=> 'required',
				'input_detail_harga_beli'=> 'required',
				'input_detail_harga_jual'=> 'required',
				'input_detail_bahan'	=> 'required',
				'input_detail_bahan_id' => 'required',
				// 'input_detail_foto'		=> 'required',
				'input_detail_produk_id'=> 'required',
				'input_jenis_id'		=> 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
					'type' => 'error',
					'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$input = $request->all();
				$id = sprintf("%03d",$request->input('input_jenis_id')).time();
				$produk = Produk::where('id',$request->input('input_detail_produk_id'));
				if ($produk->exists()) {
					$produk = $produk->first();
					$prefix = sprintf("%03d",$request->input('input_jenis_id')).sprintf("%02d",$request->input('input_detail_bahan_id')).sprintf("%03d",$request->input('input_tema_id')).sprintf("%03d",$request->input('input_judul_id'));
    				$barcode = Produk::createBarcode($prefix);
	    			ProdukDetail::create([
						'id'			=> $id,
						'sub_id'		=> $request->input('input_detail_produk_id'),
					    'barcode' 		=> $barcode,
					    'nama' 			=> $request->input('input_detail_nama'),
					    'stok' 			=> $request->input('input_detail_stok'),
					    'harga_beli' 	=> $request->input('input_detail_harga_beli'),
					    'harga_jual' 	=> $request->input('input_detail_harga_jual'),
			    		'diskon' 		=> $produk->diskon,
			    		'total_terbeli'	=> 0,
			    		'total_view'	=> 0,
			    		'detail'		=> $produk->detail.' '.($request->input('input_detail_deskripsi')!='' ? $request->input('input_detail_deskripsi') : NULL),
					    'hastag'		=> $produk->hastag.' '.($request->input('input_detail_hastag')!='' ? $request->input('input_detail_hastag') : NULL),
					    'bintang'		=> 0,
					    'status_tampil_stok'			=> $produk->status_tampil_stok,
					    'status_tampil_harga_detail'	=> $produk->status_tampil_harga_detail,
					    'status_gratis_ongkir'			=> $produk->status_gratis_ongkir,
					    'status_confirm'	=> $produk->status_confirm,
					    'user_id'			=> $produk->user_id,
					    'jenis_id'			=> sprintf("%03d",$request->input('input_jenis_id')),
					    'bahan_id'			=> $request->input('input_detail_bahan_id')!='' ? sprintf("%02d",$request->input('input_detail_bahan_id')) : NULL,
					    'tema_id'			=> $produk->tema_id,
					    'judul_id'			=> $produk->judul_id,
					    'satuan_id'			=> $produk->satuan_id,
					    'sumber_toko_id'	=> $produk->sumber_toko_id,
					]);
    				if(file_exists(public_path($produk->foto_thumnail)) && $produk->foto_thumnail!=''){
				    	unlink(public_path($produk->foto_thumnail));
				    }
				    $cekChild = Produk::hasChildMaxMin($request->input('input_detail_produk_id'));
				    $produk->barcode	 	= NULL;
					$produk->stok 			= $cekChild->stok;
					$produk->harga_beli 	= NULL;
					$produk->harga_jual 	= NULL;
					$produk->bahan_id 		= NULL;
					$produk->save();

	    			if ($request->input_detail_foto!='') {
	    				$input['image'] = $id.'_thumnail.'.$request->input_detail_foto->extension();
		        		if ($request->input_detail_foto->move(public_path('images/produk'), $input['image'])) {
		        			DB::table('trans_produk')
			                ->where('id', $id)
			                ->update(['foto_thumnail' => 'images/produk/'.$input['image']]);	

			                if(file_exists(public_path($produk->foto_thumnail)) && $produk->foto_thumnail!=''){
						    	unlink(public_path($produk->foto_thumnail));
						    }

							DB::table('trans_produk')
			                ->where('id', $request->input('input_detail_produk_id'))
			                ->update(['foto_thumnail' => 'images/produk/'.$input['image']]);	
		        		}
	    			}
					return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
				}else{
					return response()->json(['type' => 'error', 'message' => "Produk Tidak ditemukan"]);
				}
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function edit(Request $request, $id){
    	$id = explode("__", $id);
    	if($request->ajax() && count($id) > 1){
    		$produkDetail = DB::table('trans_produk')
            ->join('mst_bahan_jenis',  'trans_produk.bahan_id', '=', 'mst_bahan_jenis.id')
            ->select('trans_produk.*', 'mst_bahan_jenis.nama as mst_bahan_jenis_nama')
            ->where('trans_produk.id', $id[0])
            ->where('trans_produk.sub_id', $id[1])
            ->first();
    		return response()->json($produkDetail);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function update(Request $request, $id){
		if ($request->ajax()) {
		 // Setup the validator
				$rules = [
				'input_detail_nama' 	=> 'required',
				'input_detail_action' 	=> 'required',
				'input_detail_stok' 	=> 'required',
				'input_detail_harga_beli'=> 'required',
				'input_detail_harga_jual'=> 'required',
				'input_detail_bahan'	=> 'required',
				'input_detail_bahan_id' => 'required',
				// 'input_detail_foto'		=> 'required',
				'input_detail_produk_id'=> 'required',
				'input_jenis_id'		=> 'required',
			];
			
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$input = $request->all();
				$produkDetail = ProdukDetail::
				where('id',$input['input_detail_id'])
				->where('sub_id',$input['input_detail_produk_id']);

				$produk = Produk::where('id', $request->input_detail_produk_id);
				if ($produkDetail->exists() && $produk->exists()) {
					$updateGambarDetail 	= $produkDetail->first();
					$updateGambar 			= $produk->first();
					if ($request->input_detail_foto!='') {
						if(file_exists(public_path($updateGambarDetail->foto_thumnail)) && $updateGambarDetail->foto_thumnail!=''){
					    	unlink(public_path($updateGambarDetail->foto_thumnail));
					    }
	    				$input['image'] = $input['input_detail_id'].'_thumnail.'.$request->input_detail_foto->extension();
			    		$request->input_detail_foto->move(public_path('images/produk'), $input['image']);

			    		$updateGambarDetail-> foto_thumnail = 'images/produk/'.$input['image'];
			    		$updateGambarDetail->save();

			    		$updateGambar-> foto_thumnail = 'images/produk/'.$input['image'];
			    		$updateGambar->save();
				    }
				}
				$cekChild = Produk::hasChildMaxMin($request->input_detail_produk_id);
				$produk = $produk->first();
		    	$produk->barcode	 	= NULL;
				$produk->stok 			= $cekChild->stok;
				$produk->harga_beli 	= NULL;
				$produk->harga_jual 	= NULL;
				$produk->bahan_id 		= NULL;
				$produk->save();
				$jenis_id	= sprintf("%03d",$request->input_jenis_id);
				$bahan_id	= $request->input_detail_bahan_id!='' ? sprintf("%02d",$request->input_detail_bahan_id) : NULL;
				$tema_id	= $request->input_tema_id!=''  ? sprintf("%03d",$request->input_tema_id) : NULL;
				$judul_id	= $request->input_judul_id!='' ? sprintf("%03d",$request->input_judul_id) : NULL;
				$produkDetail = $produkDetail->first();
				if (($produkDetail->jenis_id != $jenis_id) || ($produkDetail->bahan_id != $bahan_id) || ($produkDetail->tema_id != $tema_id) || ($produkDetail->judul_id !=$judul_id)) {
    			   $prefix = sprintf("%03d",$jenis_id).sprintf("%02d",$bahan_id).sprintf("%03d",$tema_id).sprintf("%03d",$judul_id);
    				$barcode = Produk::createBarcode($prefix);
    				$produkDetail->barcode = $barcode;
    			}
			    $produkDetail->nama 			= $request->input_detail_nama;
			    $produkDetail->harga_beli 		= $request->input_detail_harga_beli;
			    $produkDetail->harga_jual 		= $request->input_detail_harga_jual;
			    $produkDetail->stok 			= $request->input_detail_stok;
	    		$produkDetail->diskon 			= $produk->diskon;
	    		$produkDetail->detail			= $produk->detail.' '.($request->input_detail_deskripsi!='' ? $request->input_detail_deskripsi : NULL);
			    $produkDetail->hastag			= $produk->hastag.' '.($request->input_detail_hastag!='' ? $request->input_detail_hastag : NULL);
			    $produkDetail->status_tampil_stok				= $produk->status_tampil_stok;
			    $produkDetail->status_tampil_harga_detail		= $produk->status_tampil_harga_detail;
			    $produkDetail->status_gratis_ongkir				= $produk->status_gratis_ongkir;
			    $produkDetail->status_confirm					= $produk->status_confirm;
			    $produkDetail->user_id							= $produk->user_id;
			    $produkDetail->jenis_id							= sprintf("%03d",$request->input_jenis_id);
			    $produkDetail->bahan_id			= $request->input_detail_bahan_id!='' ? sprintf("%02d",$request->input_detail_bahan_id) : NULL;
			    $produkDetail->tema_id			= $produk->tema_id;
			    $produkDetail->judul_id			= $produk->judul_id;
			    $produkDetail->satuan_id		= $produk->satuan_id;
			    $produkDetail->sumber_toko_id	= $produk->sumber_toko_id;
			    $produkDetail->save();
            	return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
			}
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function destroy(Request $request, $id){
    	if($request->ajax()){
			$input = $request->all();
			$produkDetail = Produk::
			where('id', $id)
    		->where('sub_id', $input['produk_id'])
    		->first();
    		if(file_exists(public_path($produkDetail->foto)) && $produkDetail->foto!=''){
		    	unlink(public_path($produkDetail->foto));
		    }
    		$produkDetail->delete();
    		$getChild = Produk::hasChildMaxMin($input['produk_id']);
    		$produk = Produk::where('id',$input['produk_id'])->first();
    		$produk->stok = $getChild->stok;
    		$produk->save();
        	return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
}
