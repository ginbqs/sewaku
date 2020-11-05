<?php

namespace App\Http\Controllers\bqs\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
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
    	return view('bqs.barang.all',compact('dt_auth'));
    }
    public function allBarang(Request $request){
    	$input = $request->all();
    	$dt_barang = Barang::getAllBarang($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_barang as $barang){
        	$url= asset($barang->gambar);
            $no++;
            $row = array();
        	$row[] = $no;
            $row[] = $barang->nama;
            $row[] = $barang->kategori;
            $row[] = $barang->gambar!='' ?  '<img src="'.$url.'"   height="50" class="img-rounded" align="center" />' : "Kosong";
            $row[] = 'Stok : '.$barang->jumlah.'<br> Terpinjam : '.$barang->terpinjam;
            $row[] = "<a data-toggle='tooltip' class='col-md-3 btn btn-warning btn-md edit' id='".$barang->id."' title='Edit'> <i class='fa fa-edit text-error'></i></a> <a data-toggle='tooltip' class='col-md-3 btn btn-danger btn-md  delete' id='".$barang->id."' title='Delete'> <i class='fa fa-trash-alt'></i></a>";

            $data[] = $row;
        }
        $output = array(
		            "draw" => $input['draw'],
		            "recordsTotal" =>  Barang::getAllBarang($input,'total'),
		            "recordsFiltered" => Barang::getAllBarang($input,'raw'),
		            "data" => $data,
		            );
		//output to json format
		echo json_encode($output);
    }
    function create(Request $request){
    	if ($request->ajax()) {
    		$dt_auth 	= Auth::user();
    		$view = View::make('bqs.barang.create')->render();
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
				'input_kategori'	=> 'required',
				'input_jumlah'		=> 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
					'type' => 'error',
					'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$id = 'B'.time();
				$barang = Barang::create([
					'id'			=> $id,
				    'nama' 			=> strtoupper(strtolower($request->input('input_nama'))),
				    'kategori' 		=> $request->input('input_kategori'),
				    'penulis' 		=> $request->input('input_penulis'),
				    'penerbit' 		=> $request->input('input_penerbit'),
				    'tahun_terbit'	=> $request->input('input_tahun_terbit'),
				    'isbn'			=> $request->input('input_isbn'),
				    'halaman'		=> $request->input('input_halaman'),
				    'jumlah'		=> $request->input('input_stok'),
				    'terpinjam'		=> 0,
				    'gambar'		=> $request->input('input_gambar'),
				    'sinopsis'		=> $request->input('input_sinopsis'),
				    'nama_rak'		=> $request->input('input_nama_rak'),
				    'lokasi_rak'	=> $request->input('input_lokasi_rak'),
				]);
				if ($request->input_gambar!='') {
					$input['image_dasar'] = $id.'.'.$request->input_gambar->extension();
	        		if ($request->input_gambar->move(public_path('images/barang'), $input['image_dasar'])) {
	        			$barang = Barang::find($id);
						$barang->gambar = 'images/barang/'.$input['image_dasar'];
						$barang->save();
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
    		$barang = DB::table('mst_barang')
            ->where('id', $id)
            ->first();
            // die($judul);
    		$view = View::make('bqs.barang.edit',compact('barang'))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function update(Request $request, $id){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator			
			$rules = [
				'input_nama' 		=> 'required',
				'input_kategori'	=> 'required',
				'input_jumlah'		=> 'required',
			];
			
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
				'type' => 'error',
				'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$barang = Barang::where('id',$id)->first();
				if ($request->input_gambar!='') {
					if(file_exists(public_path($barang->gambar))){
				    	unlink(public_path($barang->gambar));
				    }
				    $input['image_dasar'] = $id.'.'.$request->input_gambar->extension();
		    		$request->input_gambar->move(public_path('images/barang'), $input['image_dasar']);
			    }
				$barang->nama 		= strtoupper(strtolower($request->input_nama));
				$barang->kategori 	= $request->input_kategori;
				$barang->penulis	= $request->input_penulis;
				$barang->penerbit	= $request->input_penerbit;
				$barang->tahun_terbit= $request->input_tahun_terbit;
				$barang->isbn		= $request->input_isbn;
				$barang->halaman	= $request->input_halaman;
				$barang->jumlah		= $request->input_jumlah;
				if ($request->input_gambar!='') {
				$barang->gambar = 'images/barang/'.$input['image_dasar'];
				}
				$barang->sinopsis	= $request->input_sinopsis;
				$barang->nama_rak	= $request->input_nama_rak;
				$barang->lokasi_rak	= $request->input_lokasi_rak;
				$barang->save();
            	return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
			}
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function destroy(Request $request, $id){
    	if($request->ajax()){
    		$barang = Barang::find($id);
			// if(file_exists(public_path($barang->gambar)) && $barang->gambar!=''){
		 //    	unlink(public_path($barang->gambar));
		 //    }
			$barang->delete();
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
            $barang = Barang::orderby($table,'asc')->select($table)->limit(5);
        }else{
            $barang = Barang::orderby($table,'asc')->select($table)->where($table, 'like', '%' .$search . '%')->groupBy($table)->limit(5);
        }
        $barang = $barang->get();
        $response = array();
        foreach($barang as $br){
            $response[] = array("value"=>$br->$table,"label"=>$br->$table);
        }

        return response()->json($response);
    }
}
