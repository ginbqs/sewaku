<?php

namespace App\Http\Controllers\bqs\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\BarangDetail;
use App\Models\HistoriBarang;
use Illuminate\Support\Facades\Validator;
Use View;
Use DB;

class BarangController extends Controller
{
    function index(){
    	// $route = Request()->route()->getName();
    	// dd($route);
    	$dt_auth 	= Auth::user();
    	return view('admin.produk.all',compact('dt_auth'));
    }
    public function allProduk(Request $request){
    	$input = $request->all();
    	$dt_produk = Produk::getAllProduk($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_produk as $produk){
        	$url= asset($produk->foto_thumnail);
            $no++;
            $row = array();
        	$row[] = $no;
            $row[] = $produk->nama.' <br>'.$produk->stok.' '.$produk->mst_satuan_nama;
            $row[] = $produk->barcode;
            $row[] = $produk->foto_thumnail!='' ?  '<img src="'.$url.'"   height="50" class="img-rounded" align="center" />' : "Kosong";
            $row[] = $produk->total_terbeli;
            $row[] = "<a data-toggle='tooltip' class='col-md-3 btn btn-warning btn-md edit' id='".$produk->id."' title='Edit'> <i class='fa fa-edit text-error'></i></a> <a data-toggle='tooltip' class='col-md-3 btn btn-danger btn-md  delete' id='".$produk->id."' title='Delete'> <i class='fa fa-trash-alt'></i></a>";

            $data[] = $row;
        }
        $output = array(
		            "draw" => $input['draw'],
		            "recordsTotal" =>  Produk::getAllProduk($input,'total'),
		            "recordsFiltered" => Produk::getAllProduk($input,'raw'),
		            "data" => $data,
		            );
		//output to json format
		echo json_encode($output);
    }
    function create(Request $request){
    	if ($request->ajax()) {
    		$dt_satuan = Satuan::all();
    		$dt_auth 	= Auth::user();
    		if ($dt_auth->app_user_level_id=='root') {
    			$view = View::make('admin.produk.create',compact('dt_satuan'))->render();
    		}else{
    			$view = View::make('admin.produk.create_designer',compact('dt_satuan'))->render();
    		}
    		return response()->json(['html' => $view]);
    	}else{
         	return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
    	}
    }
    function store(Request $request){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_nama' 		=> 'required',
				'input_jenis' 		=> 'required',
				'input_jenis_id' 	=> 'required',
				// 'input_tema' 		=> 'required',
				// 'input_tema_id'		=> 'required',
				// 'input_judul' 		=> 'required',
				// 'input_judul_id'	=> 'required',
				'input_harga_beli'	=> 'required',
				'input_harga_jual'	=> 'required',
				'input_toko_sumber'	=> 'required',
				'input_toko_sumber_id'=> 'required',
				'input_stok'		=> 'required',
				'input_satuan'		=> 'required',
				'input_satuan_id'	=> 'required',
				// 'input_foto_dasar'  => 'required',//|mimes:zip,rar
				'input_status_confirm'=> 'required',
				'input_owner' 		=> 'required',
				'input_owner_id'	=> 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
					'type' => 'error',
					'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$id = sprintf("%03d",$request->input('input_jenis_id')).time();

    			$prefix = sprintf("%03d",$request->input('input_jenis_id')).sprintf("%02d",$request->input('input_bahan_id')).sprintf("%03d",$request->input('input_tema_id')).sprintf("%03d",$request->input('input_judul_id'));
    			$barcode = Produk::createBarcode($prefix);
				$produk = Produk::create([
					'id'			=> $id,
				    'sub_id' 		=> NULL,
				    'barcode' 		=> $barcode,
				    'nama' 			=> $request->input('input_nama'),
				    'stok' 			=> $request->input('input_stok'),
				    'harga_beli' 	=> $request->input('input_harga_beli'),
				    'harga_jual' 	=> $request->input('input_harga_jual'),
				    'diskon' 		=> $request->input('input_diskon')!='' ? $request->input('input_diskon') : 0,
				    'total_terbeli'	=> 0,
				    'total_view'	=> 0,
				    'detail'		=> $request->input('input_deskripsi')!='' ? $request->input('input_deskripsi') : NULL,
				    'hastag'		=> $request->input('input_hastag')!='' ? $request->input('input_hastag') : NULL,
				    'bintang'		=> 0,
				    'status_tampil_stok'	=> $request->input('input_tampilkan_stok')=='on' ? 1 : 0,
				    'status_tampil_harga_detail'	=> $request->input('input_tampilkan_harga_detail')=='on' ? 1 : 0,
				    'status_gratis_ongkir'	=> $request->input('input_gratis_ongkir')=='on' ? 1 : 0,
				    'status_confirm'	=> $request->input('input_status_confirm')=='on' ? 1 : 0,
				    'user_id'			=> $request->input('input_owner_id'),
				    'jenis_id'			=> sprintf("%03d",$request->input('input_jenis_id')),
				    'bahan_id'			=> $request->input('input_bahan_id')!='' ? sprintf("%02d",$request->input('input_bahan_id')) : NULL,
				    'tema_id'			=> $request->input('input_tema_id')!='' ? sprintf("%03d",$request->input('input_tema_id')) : NULL,
				    'judul_id'			=> $request->input('input_judul_id')!='' ? sprintf("%03d",$request->input('input_judul_id')) : NULL,
				    'satuan_id'			=> sprintf("%02d",$request->input('input_satuan_id')),
				    'sumber_toko_id'	=> $request->input('input_toko_sumber_id')
				]);
				if ($request->input_foto_dasar!='') {
					$input['image_dasar'] = $id.'_dasar.'.$request->input_foto_dasar->extension();
	        		if ($request->input_foto_dasar->move(public_path('images/produk'), $input['image_dasar'])) {
	        			$produk = Produk::find($id);
						$produk->foto_dasar = 'images/produk/'.$input['image_dasar'];
						$produk->save();
	        		}
				}
				if ($request->input_foto_thumnail!='') {
					$input['image_thumnail'] = $id.'_thumnail.'.$request->input_foto_thumnail->extension();
	        		if ($request->input_foto_thumnail->move(public_path('images/produk'), $input['image_thumnail'])) {
	        			$produk = Produk::find($id);
						$produk->foto_thumnail = 'images/produk/'.$input['image_thumnail'];
						$produk->save();
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
    		$produk = DB::table('trans_produk')
    		->join('app_user_list',  'app_user_list.id', '=', 'trans_produk.user_id')
    		->join('mst_jenis_produk',  'mst_jenis_produk.id', '=', 'trans_produk.jenis_id')
    		->leftJoin('mst_tema_jenis',  'mst_tema_jenis.id', '=', 'trans_produk.tema_id')
    		->leftJoin('mst_judul_tema',  'mst_judul_tema.id', '=', 'trans_produk.judul_id')
    		->leftJoin('mst_bahan_jenis',  'mst_bahan_jenis.id', '=', 'trans_produk.bahan_id')
    		->join('mst_satuan',  'mst_satuan.id', '=', 'trans_produk.satuan_id')
    		->join('mst_sumber_toko',  'mst_sumber_toko.id', '=', 'trans_produk.sumber_toko_id')
            ->select('trans_produk.*', 'app_user_list.name as app_user_list_name', 'mst_jenis_produk.nama as mst_jenis_produk_nama', 'mst_tema_jenis.nama as mst_tema_jenis_nama', 'mst_judul_tema.nama as mst_judul_tema_nama', 'mst_satuan.nama as mst_satuan_nama', 'mst_sumber_toko.nama as mst_sumber_toko_nama','mst_bahan_jenis.nama as mst_bahan_jenis_nama')
            ->where('trans_produk.id', $id)
            ->first();
            // die($judul);
    		$view = View::make('admin.produk.edit',compact('produk'))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function update(Request $request, $id){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator			
			$rules2 = [];
			$rules1 = [
				'input_nama' 		=> 'required',
				'input_jenis' 		=> 'required',
				'input_jenis_id' 	=> 'required',
				// 'input_tema' 		=> 'required',
				// 'input_tema_id'		=> 'required',
				// 'input_judul' 		=> 'required',
				// 'input_judul_id'	=> 'required',
				'input_toko_sumber'	=> 'required',
				'input_toko_sumber_id'=> 'required',
				'input_satuan'		=> 'required',
				'input_satuan_id'	=> 'required',
				// 'input_foto_dasar' 	=> 'required',|mimes:zip,rar
			];
			$cekChild = Produk::hasChildMaxMin($id);
			if (empty($cekChild->min_harga_beli)) {
				$rules2 = [
					'input_harga_beli'	=> 'required',
					'input_harga_jual'	=> 'required',
					'input_stok'		=> 'required',
				];
			}
			$rules = array_merge($rules1,$rules2);
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				if ($request->input_foto_dasar!='') {
					$gambar = Produk::where('id',$id)->first();
					if(file_exists(public_path($gambar->foto_dasar))){
				    	unlink(public_path($gambar->foto_dasar));
				    }
				    $input['image_dasar'] = $id.'_dasar.'.$request->input_foto_dasar->extension();
		    		$request->input_foto_dasar->move(public_path('images/produk'), $input['image_dasar']);
			    }
			    if ($request->input_foto_thumnail!='') {
					$gambar = Produk::where('id',$id)->first();
					if(file_exists(public_path($gambar->foto_thumnail))){
				    	unlink(public_path($gambar->foto_thumnail));
				    }
				    $input['image_thumnail'] = $id.'_thumnail.'.$request->input_foto_thumnail->extension();
		    		$request->input_foto_thumnail->move(public_path('images/produk'), $input['image_thumnail']);
			    }
        		$produkDetail = ProdukDetail::where('sub_id',$id)->exists();
    			$produk = Produk::find($id);
    			$jenis_id	= sprintf("%03d",$request->input_jenis_id);
				$bahan_id	= $request->input_bahan_id!='' ? sprintf("%02d",$request->input_bahan_id) : NULL;
				$tema_id	= $request->input_tema_id!=''  ? sprintf("%03d",$request->input_tema_id) : NULL;
				$judul_id	= $request->input_judul_id!='' ? sprintf("%03d",$request->input_judul_id) : NULL;
    			if (($produk->jenis_id != $jenis_id) || ($produk->bahan_id != $bahan_id) || ($produk->tema_id != $tema_id) || ($produk->judul_id !=$judul_id)) {
    			   $prefix = sprintf("%03d",$request->input('input_jenis_id')).sprintf("%02d",$request->input('input_bahan_id')).sprintf("%03d",$request->input('input_tema_id')).sprintf("%03d",$request->input('input_judul_id'));
    				$barcode = $produkDetail ? NULL : Produk::createBarcode($prefix);
    				$produk->barcode = $barcode;
    			}
				$produk->nama 		= strtoupper(strtolower($request->input_nama));
				if (!$produkDetail) {
					$produk->harga_beli = $request->input_harga_beli;
					$produk->harga_jual = $request->input_harga_jual;
					$produk->stok 		= $request->input_stok;
				}
				$produk->diskon 	= $request->input_diskon!='' ? $request->input_diskon : 0;
				$produk->detail		= $request->input_deskripsi!='' ? $request->input_deskripsi : NULL;
				$produk->hastag		= $request->input_hastag!='' ? $request->input_hastag : NULL;
				$produk->status_tampil_stok	= $request->input_tampilkan_stok=='on' ? 1 : 0;
				$produk->status_tampil_harga_detail	= $request->input_tampilkan_harga_detail=='on' ? 1 : 0;
				$produk->status_gratis_ongkir	= $request->input_gratis_ongkir=='on' ? 1 : 0;
				$produk->status_confirm	= $request->input('input_status_confirm')=='on' ? 1 : 0;
				if ($request->input_foto_dasar!='') {
				$produk->foto_dasar = 'images/produk/'.$input['image_dasar'];
				}
				if ($request->input_foto_thumnail!='') {
				$produk->foto_thumnail = 'images/produk/'.$input['image_thumnail'];
				}
				$produk->user_id	= $request->input_owner_id!='' ? $request->input_owner_id : $dt_auth->id;
				$produk->jenis_id	= sprintf("%03d",$request->input_jenis_id);
				if (!$produkDetail) {
					$produk->bahan_id	= $request->input_bahan_id!='' ? sprintf("%02d",$request->input_bahan_id) : NULL;
				}else{
					$produk->bahan_id	= NULL;
				}
				$produk->tema_id	= $request->input_tema_id!='' ? sprintf("%03d",$request->input_tema_id) : NULL;
				$produk->judul_id	= $request->input_judul_id!='' ? sprintf("%03d",$request->input_judul_id) : NULL;
				$produk->satuan_id	= sprintf("%02d",$request->input_satuan_id);
				$produk->sumber_toko_id= $request->input_toko_sumber_id;
				$produk->save();
            	return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
			}
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function destroy(Request $request, $id){
    	if($request->ajax()){
    		$gambar = DB::table('trans_produk')
    		->where('sub_id', $id)
    		->get();
    		foreach ($gambar as $key) {
    			if(file_exists(public_path($key->foto_dasar)) && $key->foto_dasar!=''){
			    	unlink(public_path($key->foto_dasar));
			    }
			    if(file_exists(public_path($key->foto_thumnail)) && $key->foto_thumnail!=''){
			    	unlink(public_path($key->foto_thumnail));
			    }
    		}
    		DB::table('trans_produk')
    		->where('sub_id', $id)
    		->delete();

    		$gambar2 = Produk::find($id);
			if(file_exists(public_path($gambar2->foto_dasar)) && $gambar2->foto_dasar!=''){
		    	unlink(public_path($gambar2->foto_dasar));
		    }
		    if(file_exists(public_path($gambar2->foto_thumnail)) && $gambar2->foto_thumnail!=''){
		    	unlink(public_path($gambar2->foto_thumnail));
		    }

    		$judul = Produk::find($id);
			$judul->delete();
        	return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function cekChild($produk_id){
    	$dtProduk = Produk::hasChildMaxMin($produk_id);
    	$history  = HistoriProduk::where('produk_id',$produk_id)->exists();
		return response()->json([
			'status' 		=> 'true', 
			'hasChild' 		=> isset($dtProduk->min_harga_beli) ? true: false,
			'harga_beli' 	=> 'Rp. '.number_format($dtProduk->min_harga_beli,2).' - '.'Rp. '.number_format($dtProduk->max_harga_beli,2),
			'harga_jual' 	=> 'Rp. '.number_format($dtProduk->min_harga_jual,2).' - '.'Rp. '.number_format($dtProduk->max_harga_jual,2),
			'stok' 			=> $dtProduk->stok,
			'hasHistory' 	=> $history,
		]);
    }
}
