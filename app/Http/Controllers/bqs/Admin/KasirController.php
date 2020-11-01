<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
Use View;
Use DB;

use App\Models\Kasir\Pengeluaran;
use App\Models\Produk;
use App\Models\KasirLock;
use App\Models\KasirDetailTemp;
use App\Models\Kasir;
use App\Models\KasirDetail;
use App\Models\HistoriProduk;
use App\Models\Kasir\PengeluaranDetail;
use App\Models\PaketMenu;
use App\Models\PaketMenuDetail;
use App\Models\Panel\App_config;

class KasirController extends Controller
{
    function index(){
    	$kasirLock = KasirLock::where('status','1')->first();
    	return view('admin.kasir.all',compact('kasirLock'));
    }
	function checkOutHp(){
    	return view('admin.kasir.checkoutHp');
    }    
    public function allProduk(Request $request){
    	$input = $request->all();
    	$dt_produk = Produk::getAllProduk($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_produk as $produk){
            $child = Produk::hasChildMaxMin($produk->id);
        	if (isset($child->harga_max)!='' && isset($child->harga_min)!='') {
        		$harga_max 		= ($child->harga_max > 0 ? number_format($child->harga_max,2) : '');
        		$harga_min 		= ($child->harga_min > 0 ? number_format($child->harga_min,2) : '');
        		$tampil_harga 	= $harga_min.' - '.$harga_max;

        		$tgl_kadaluarsa_max = ($child->tgl_kadaluarsa_max !='' ? date("d M Y",strtotime($child->tgl_kadaluarsa_max)) : '');
        		$tgl_kadaluarsa_min = ($child->tgl_kadaluarsa_min !='' ? date("d M Y",strtotime($child->tgl_kadaluarsa_min)) : '');
        		$tampil_expire 		= $tgl_kadaluarsa_min.' - '.$tgl_kadaluarsa_max;
        		$nama = $produk->nama.'<ul><li>'.$produk->stok.' '.$produk->mst_satuan_nama.'</li><li>Rp. '.$tampil_harga.'</li><li>ED : '.($produk->status_expire=='1' ? $tampil_expire : '-').'</li></ul>';
        	}else{
        		$nama = $produk->nama.'<ul><li>'.$produk->stok.' '.$produk->mst_satuan_nama.'</li><li>Rp. '.number_format($produk->harga_jual,2).'</li><li>ED : '.($produk->status_expire=='1' ? date("d M Y",strtotime($produk->tgl_kadaluarsa)) : '-').'</li></ul>';
        	}
        	$url= asset($produk->foto_thumnail);
            $foto = ($produk->foto_thumnail!='' ?  '<img src="'.$url.'"   height="50" class="img-rounded" align="center" />' : "");
            $html = "<div class='row editPembelian' id='".$produk->id."'>";
            	if ($foto!='') {
	            	$html .= "<div class='col-4'>";
            			$html .= $foto;
            		$html .= "</div>";
	            	$html .= "<div class='col-8'>";
            	}else{
	            	$html .= "<div class='col-12'>";
            	}
            			$html .= $nama;
            		$html .= "</div>";
            $html .= "</div>";
            $row = array();
        	$row[] = $html;

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
    function cekKasirAbsen(){
    	$response['bukaKasir'] = KasirLock::where('status','1')->exists();
		echo json_encode($response);
    }
    function bukaKasir(Request $request){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_saldoAwal'		=> 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
					'type' => 'error',
					'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$input = $request->all();
				KasirLock::create([
					'id'			=> time(),
					'tanggal'		=> date("Y-m-d"),
					'time'			=> time(),
					'nilai_awal'	=> $input['input_saldoAwal'],
					'nilai_akhir'	=> 0,
					'status'		=> 1,
					'keterangan'	=> $input['input_catatan'],
					'user_id'		=> $dt_auth->id,
				]);
				return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function pembelianProduk(Request $request,$id){
    	if($request->ajax()){
    		$produk = DB::table('trans_produk')
    		->join('mst_satuan',  'mst_satuan.id', '=', 'trans_produk.satuan_id')
            ->select('trans_produk.*', 'mst_satuan.nama as mst_satuan_nama')
            ->where('trans_produk.id', $id)
            ->first();
    		$view = View::make('admin.kasir.editProduk',compact(['produk']))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function createPembelian(Request $request){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_detail_action'		=> 'required',
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
					$diskonProduk	= $input['input_diskon_produk'];
				    if (isset($input['keranjang_id']) && $input['keranjang_id']!='') {
						foreach ($input as $key => $value) {
							if (substr($key, 0,25)=='input_jumlah_beli_produk_') {
								$idProduk 	= explode('_', $key);
								$kasir 		= KasirLock::where('status',1)->first();
								if ($value < 1) {
									$keranjang = KasirDetailTemp::where('id',sprintf('%05d', $input['keranjang_id']))->where('kasir_lock_id',$kasir->id)->where('produk_id',$idProduk[4]);
									$keranjang->delete();
								}else{
									$produk 	= Produk::where('id',$idProduk[4])->first();
									if (((int)$produk->stok - (int)$value) < 0) {
							    		DB::rollback();
										return response()->json(['type' => 'error', 'message' =>  $produk->nama." hanya memiliki stok ".$produk->stok]);
							    	}
									DB::table('trans_kasir_detail_temp')
					                ->where('id', sprintf('%05d', $input['keranjang_id']))
					                ->where('kasir_lock_id', $kasir->id)
					                ->where('produk_id', $idProduk[4])
					                ->update([
					                	'jumlah' 		=> $value,
					                	'harga_beli' 	=> $produk->harga_beli,
					                	'harga_jual' 	=> $produk->harga_jual,
					                	'diskon'		=> $diskonProduk,
									    'harga_terjual'	=> $diskonProduk > 0 ? ($produk->harga_jual - ($produk->harga_jual*$diskonProduk)/100) : $produk->harga_jual,
					                	'keterangan' 	=> '-',
					                ]);
								}
							}
						}
				    }else{
				    	$id 			= 'M'.time();
						foreach ($input as $key => $value) {
							if (substr($key, 0,25)=='input_jumlah_beli_produk_') {
								$idProduk 	= explode('_', $key);
								$produk 	= Produk::where('id',$idProduk[4])->first();
								$kasir 		= KasirLock::where('status',1)->first();
								$idDetail   = KasirDetailTemp::getID($kasir->id);
								$cekTempDuplicate = KasirDetailTemp::where('produk_id',$idProduk[4])->where('kasir_lock_id',$kasir->id);
								if (!$cekTempDuplicate->exists()) {
									if (((int)$produk->stok - (int)$value) >= 0) {
										KasirDetailTemp::create([
											'id'			=> $idDetail,
										    'kasir_lock_id'	=> $kasir->id,
										    'produk_id'		=> $idProduk[4],
										    'jumlah'		=> $value,
										    'harga_beli'	=> $produk->harga_beli,
										    'harga_jual'	=> $produk->harga_jual,
										    'diskon'		=> $diskonProduk,
										    'harga_terjual'	=> $diskonProduk > 0 ? ($produk->harga_jual - ($produk->harga_jual*$diskonProduk)/100) : $produk->harga_jual,
										    'keterangan'	=> '-',
										]);
							    	}else{
										DB::rollback();
										return response()->json(['type' => 'error', 'message' =>  $produk->nama." hanya memiliki stok ".$produk->stok]);
							    	}
								}else{
									$duplicate = $cekTempDuplicate->first();
									$duplicate->jumlah 		= $duplicate->jumlah+$value;
									$duplicate->harga_beli 	= $produk->harga_beli;
									$duplicate->harga_jual 	= $produk->harga_jual;
									$duplicate->diskon 		= $diskonProduk;
									$duplicate->harga_terjual= $diskonProduk > 0 ? ($produk->harga_jual - ($produk->harga_jual*$diskonProduk)/100) : $produk->harga_jual;
									$duplicate->save();
									// return response()->json(['type' => 'error', 'message' => "Data Sudah pernah di masukan Keranjang. Silahkan edit data pada keranjang"]);
								}
							}
						}
				    }
				    DB::commit();
					return response()->json(['type' => 'success', 'message' => "Successfully Created"]);

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
    function getKeranjang(){
    	$kasir = KasirDetailTemp::select(DB::raw("sum(jumlah) as total_item"),DB::raw("sum(jumlah*harga_beli) as total_nilai_asal"),DB::raw("sum(jumlah*harga_jual) as total_nilai_jual"),DB::raw("sum(jumlah*harga_terjual) as total_nilai_terjual"))->first();
		return response()->json(['message' => 'success', 'data' => $kasir]);
    }
    public function allKeranjang(Request $request){
    	$input = $request->all();
    	$dt_keranjang = KasirDetailTemp::getAllKeranjang($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_keranjang as $keranjang){
            $no++;
            $row = array();
            
            $row[] = $keranjang->id;
            $row[] = $keranjang->trans_produk_nama;
            $row[] = $keranjang->jumlah.' '.$keranjang->mst_satuan_nama;
            $row[] = number_format($keranjang->harga_terjual,2);
            $row[] = number_format($keranjang->jumlah * $keranjang->harga_terjual,2);

            $data[] = $row;
        }
        $output = array(
		            "draw" => $input['draw'],
		            "recordsTotal" =>  KasirDetailTemp::getAllKeranjang($input,'total'),
		            "recordsFiltered" => KasirDetailTemp::getAllKeranjang($input,'raw'),
		            "data" => $data,
		            );
		//output to json format
		echo json_encode($output);
    }
    function keranjangProduk(Request $request,$id){
    	if($request->ajax()){
    		$produk = DB::table('trans_produk')
    		->join('trans_kasir_detail_temp',  'trans_produk.id', '=', 'trans_kasir_detail_temp.produk_id')
    		->join('mst_satuan',  'mst_satuan.id', '=', 'trans_produk.satuan_id')
            ->select('trans_produk.*', 'mst_satuan.nama as mst_satuan_nama','trans_kasir_detail_temp.jumlah','trans_kasir_detail_temp.harga_jual','trans_kasir_detail_temp.id as keranjang_id','trans_kasir_detail_temp.diskon')
            ->where('trans_kasir_detail_temp.id', $id)
            ->first();
    		$view = View::make('admin.kasir.editProduk',compact(['produk']))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function checkOut(Request $request){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_subtotal'	=> 'required',
				'input_diskon'		=> 'required',
				'input_total_bayar'	=> 'required',
				'input_bayar'		=> 'required',
				'input_selisih'		=> 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
					'type' => 'error',
					'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$input = $request->all();
				DB::beginTransaction();
				try {
				    $input = $request->all();
					$kasirLock 	= KasirLock::where('status',1)->first();
					$total 		= KasirDetailTemp::select(DB::raw("sum(jumlah) as total_item"),DB::raw("sum(jumlah*harga_beli) as total_nilai_asal"),DB::raw("sum(jumlah*harga_jual) as total_nilai_jual"),DB::raw("sum(jumlah*harga_terjual) as total_nilai_terjual"))->first();
					$idKasir = 'K'.time();
					$kasir = Kasir::create([
						'id'			=> $idKasir,
						'tanggal'		=> date("Y-m-d H:i:s"),
						'time'			=> time(),
						'pembeli'		=> $input['input_pembeli'],
						'pembeli_id'	=> isset($input['pembeli_id']) && $input['pembeli_id'] && $input['pembeli_id']!='' ? $input['pembeli_id'] : NULL,
						'total_item'	=> $total->total_item,
						'total_asal'	=> $total->total_nilai_asal,
						'total_nilai'	=> $total->total_nilai_jual,
						'diskon'		=> $input['input_diskon'],
						'total_bayar'	=> $input['input_total_bayar'],
						'total_terbayar'=> $input['input_bayar'],
						'total_hutang'	=> $input['input_bayar'] - $input['input_total_bayar'],
						'keterangan'	=> '-',
						'kasir_lock_id'	=> $kasirLock->id,
						'user_id'		=> 	$dt_auth->id,
					]);
			    	$dt_keranjang = KasirDetailTemp::all();
					foreach ($dt_keranjang as $key) {
			    		$produk = Produk::where('id',$key->produk_id)->first();
			    		if (((int)$produk->stok - (int)$key['jumlah']) < 0) {
				    		DB::rollback();
							return response()->json(['type' => 'error', 'message' =>  $produk->nama." hanya memiliki stok ".$produk->stok]);
				    	}
						$idProduk 	= $key->produk_id;
						$idDetail   = KasirDetail::getID($idKasir);
			    		
						KasirDetail::create([
							'id'			=> $idDetail,
						    'kasir_id'		=> $idKasir,
						    'produk_id'		=> $idProduk,
						    'jumlah'		=> $key['jumlah'],
						    'harga_beli'	=> $key['harga_beli'],
						    'harga_jual'	=> $key['harga_jual'],
						    'diskon'		=> $key['diskon'],
						    'harga_terjual'	=> $key['harga_terjual'],
						    'keterangan'	=> '-',
						]);
						HistoriProduk::create([
				    		'link'			=> 'kasir/'.$idKasir.'/edit',
				    		'jenis'			=> 'kasir',
				    		'time'			=> time(),
				    		'produk_id'		=> $idProduk,
				    		'stok_awal'		=> $produk->stok,
				    		'stok_akhir'	=> (int)$produk->stok - $key['jumlah'],
				    		'stok_selisih'	=> -1 * (int)$key['jumlah'],
				    		'harga'			=> $key['harga_terjual'],
				    		'keterangan' 	=> 'Kasir oleh = '.$dt_auth->id
				    	]);

				    	$produk->total_terbeli = $produk->total_terbeli+$key['jumlah'];
			    		$produk->stok = $produk->stok - $key['jumlah'];
			    		$produk->save();

			    		Produk::UpdateStok($produk->sub_id,'update');
					}
					KasirDetailTemp::truncate();
				    DB::commit();
					return response()->json(['type' => 'success', 'message' => "Successfully Created"]);

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
    function hitungKasir(){
    	$kasirBuka = KasirLock::where('status','1')->first();
    	$kasir = KasirDetail::select(DB::raw("sum(jumlah) as total_item"),DB::raw("sum(jumlah*harga_beli) as total_nilai_asal"),DB::raw("sum(jumlah*harga_jual) as total_nilai_jual"),DB::raw("sum(jumlah*harga_terjual) as total_nilai_terjual"))->first();
		$view = View::make('admin.kasir.hitungKasir',compact(['kasir','kasirBuka']))->render();
    	return response()->json(['html' => $view]);
    }
    function tutupKasir(Request $request){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_saldo_akhir'		=> 'required',
				'input_saldo_manual'	=> 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
					'type' => 'error',
					'errors' => $validator->getMessageBag()->toArray()
				]);
			} else {
				$input = $request->all();
				DB::table('trans_kasir_lock')
                ->where('status', '1')
                ->update([
                	'nilai_akhir' 	=> $input['input_saldo_akhir'],
                	'nilai_fisik' 	=> $input['input_saldo_manual'],
                	'status' 		=> '2',
                	'time' 			=> time(),
                ]);
				return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
			}
		} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    public function allPaket(Request $request){
    	$input = $request->all();
    	$dt_paketMenu = PaketMenu::getAllPaketMenu($input,'data');
        $no = isset($input['start']) ? $input['start'] : 0;
        $data = array();
        foreach($dt_paketMenu as $paketMenu){
        	$dtPaket='';
        	$paket = PaketMenuDetail::getPaket($paketMenu->id);
        	foreach ($paket->get() as $key) {
        		$dtPaket .= '<ul>';
        		$dtPaket .= '<li>'.$key->jumlah.' '.$key->trans_produk_nama.'</li>';
        		$dtPaket .= '</ul>';
        	}
            $no++;
            $row = array();
            $row[] = "<div class='editPaket' id='".$paketMenu->id."'>". $paketMenu->keterangan.' :<br>'.$dtPaket.'</di>';

            $data[] = $row;
        }
        $output = array(
		            "draw" => $input['draw'],
		            "recordsTotal" =>  PaketMenu::getAllPaketMenu($input,'total'),
		            "recordsFiltered" => PaketMenu::getAllPaketMenu($input,'raw'),
		            "data" => $data,
		            );
		//output to json format
		echo json_encode($output);
    }
    function pembelianPaket(Request $request,$id){
    	if($request->ajax()){
    		$paket = DB::table('trans_paket_menu')
            ->select('trans_paket_menu.*')
            ->where('trans_paket_menu.id', $id)
            ->first();
    		$view = View::make('admin.kasir.editPaket',compact(['paket']))->render();
    		return response()->json(['html' => $view]);
    	} else {
			return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
		}
    }
    function createPembelianPaket(Request $request){
    	$dt_auth 	= Auth::user();
		if ($request->ajax()) {
		 // Setup the validator
			$rules = [
				'input_detail_action'		=> 'required',
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
			    	$id 			= 'M'.time();
			    	$produk 		= PaketMenuDetail::where('paket_menu_id',$input['paket_id'])->get();
			    	$jumlah 		= $input['input_jumlah_beli_paket_'.$input['paket_id']];
			    	$diskonProduk 	= 0;
					foreach ($produk as $key) {
						$produk 	= Produk::where('id',$key->produk_id)->first();
						$kasir 		= KasirLock::where('status',1)->first();
						$idDetail   = KasirDetailTemp::getID($kasir->id);
						$cekTempDuplicate = KasirDetailTemp::where('produk_id',$key->produk_id)->where('kasir_lock_id',$kasir->id);
						if (!$cekTempDuplicate->exists()) {
							if (((int)$produk->stok - (int)$jumlah) >= 0) {
					   //  		DB::rollback();
								// return response()->json(['type' => 'error', 'message' =>  $produk->nama." hanya memiliki stok ".$produk->stok]);
								KasirDetailTemp::create([
									'id'			=> $idDetail,
								    'kasir_lock_id'	=> $kasir->id,
								    'produk_id'		=> $key->produk_id,
								    'jumlah'		=> $key->jumlah * $jumlah,
								    'harga_beli'	=> $produk->harga_beli,
								    'harga_jual'	=> $produk->harga_jual,
								    'diskon'		=> $diskonProduk,
								    'harga_terjual'	=> $diskonProduk > 0 ? ($produk->harga_jual - ($produk->harga_jual*$diskonProduk)/100) : $produk->harga_jual,
								    'keterangan'	=> '-',
								]);
					    	}
						}else{
							$duplicate = $cekTempDuplicate->first();
							$duplicate->jumlah 		= $duplicate->jumlah+($key->jumlah * $jumlah);
							$duplicate->harga_beli 	= $produk->harga_beli;
							$duplicate->harga_jual 	= $produk->harga_jual;
							$duplicate->diskon 		= $duplicate->diskon;
							$duplicate->harga_terjual= $duplicate->diskon > 0 ? ($produk->harga_jual - ($produk->harga_jual*$duplicate->diskon)/100) : $produk->harga_jual;
							$duplicate->save();
							// return response()->json(['type' => 'error', 'message' => "Data Sudah pernah di masukan Keranjang. Silahkan edit data pada keranjang"]);
						}
					}
				    DB::commit();
					return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
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
    function print_pembelian(Request $request){
    	$input = $request->all();
    	$total 		= KasirDetailTemp::select(DB::raw("sum(jumlah) as total_item"),DB::raw("sum(jumlah*harga_beli) as total_nilai_asal"),DB::raw("sum(jumlah*harga_jual) as total_nilai_jual"),DB::raw("sum(jumlah*harga_terjual) as total_nilai_terjual"))->first();
    	$input['search'] =[''];
    	$dt_kasir 	= DB::table('trans_kasir_detail_temp')
        	->join('trans_produk','trans_produk.id','=','trans_kasir_detail_temp.produk_id')
        	->join('mst_satuan','mst_satuan.id','=','trans_produk.satuan_id')
            ->select('trans_kasir_detail_temp.*','trans_produk.nama as trans_produk_nama' ,'mst_satuan.nama as mst_satuan_nama',DB::raw('@rownum:= @rownum +1 As rownum'))->get();
    	$nama 		= App_config::where('id','nama_toko')->first();
    	$alamat 	= App_config::where('id','web_alamat')->first();
    	$kasir  	= (object)array();
    	$kasir->pembeli 	= $input['pembeli'];
    	$kasir->sub_total 	= $input['sub_total'];
    	$kasir->diskon 		= $input['diskon'];
    	$kasir->total_bayar = $input['total_bayar'];
    	$kasir->bayar 		= $input['bayar'];
    	$kasir->kembalian 	= $input['kembalian'];
    	return view('admin.kasir.print',compact(['total','dt_kasir','nama','alamat','kasir']));
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
}
