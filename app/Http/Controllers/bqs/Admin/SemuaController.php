<?php

namespace App\Http\Controllers\bqs\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kasir;
use App\Models\KasirDetail;
use App\Models\Barang;
use App\User;
use DB;

class SemuaController extends Controller
{
    public function index(){
    	$bulan = [1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
    	return view('bqs.semua.all',compact(['bulan']));
    }
    function getChartSemuaTrans(Request $request){
    	$input = $request->all();
    	$bulan = [1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
    	if ($input['filter_jenis_chart']=='tahunan') {
    		$kasir = Kasir::select(DB::raw('sum(total_bayar) as total_bayar'),DB::raw('sum(total_denda) as total_denda'),DB::raw('sum(total_uang) as total_uang'),DB::raw('MONTH(tanggal_dikembalikan) as bulan'))->where('status','kembali')->where(DB::raw('YEAR(tanggal_dikembalikan)'),$input['filter_tahun'])->groupBy(DB::raw('MONTH(tanggal_dikembalikan)'));
            $nilai_bayar = array();
            $nilai_denda = array();
            $nilai_total = array();
    		$nilai_uang = array();
    		foreach ($kasir->get() as $key) {
                $nilai_bayar[(int)$key->bulan] = $key->total_bayar;
                $nilai_denda[(int)$key->bulan] = $key->total_denda;
                $nilai_total[(int)$key->bulan] = $key->total_bayar + $key->total_denda;
    			$nilai_uang[(int)$key->bulan] = $key->total_uang;
    		}
    		$dt_bulan = array();
            $dt_nilai_bayar = array();
            $dt_nilai_denda = array();
            $dt_nilai_total = array();
    		$dt_nilai_uang = array();
    		foreach ($bulan as $key => $val) {
    			$dt_bulan[] = $val;
    			$nlBayar = isset($nilai_bayar[$key]) ? $nilai_bayar[$key] : 0;
    			$dt_nilai_bayar[] = $nlBayar;

                $nlDenda = isset($nilai_denda[$key]) ? $nilai_denda[$key] : 0;
                $dt_nilai_denda[] = $nlDenda;

                $nlTotal = (isset($nilai_bayar[$key]) ? $nilai_bayar[$key] : 0) + (isset($nilai_denda[$key]) ? $nilai_denda[$key] : 0);
                $dt_nilai_total[] = $nlTotal;

                $nlUang = isset($nilai_uang[$key]) ? $nilai_uang[$key] : 0;
                $dt_nilai_uang[] = $nlUang;
    		}
			return response()->json(['status' => true, 'nilai_bayar' => $dt_nilai_bayar , 'nilai_denda' => $dt_nilai_denda , 'nilai_total' => $dt_nilai_total , 'nilai_uang' => $dt_nilai_uang , 'x_column' => $dt_bulan]);
    	}else if ($input['filter_jenis_chart']=='bulanan') {;
            $kasir = Kasir::select(DB::raw('sum(total_bayar) as total_bayar'),DB::raw('sum(total_denda) as total_denda'),DB::raw('sum(total_uang) as total_uang'),DB::raw('SUBSTRING(tanggal_dikembalikan,9,2) as tanggal'))
            ->where('status','kembali')
            ->where(DB::raw('YEAR(tanggal_dikembalikan)'),$input['filter_tahun'])
            ->where(DB::raw('MONTH(tanggal_dikembalikan)'),$input['filter_bulan'])
            ->groupBy(DB::raw('SUBSTRING(tanggal_dikembalikan,9,2)'));

            $nilai_bayar = array();
            $nilai_denda = array();
            $nilai_total = array();
            $nilai_uang = array();
    		foreach ($kasir->get() as $key) {
                $nilai_bayar[(int)$key->tanggal] = $key->total_bayar;
                $nilai_denda[(int)$key->tanggal] = $key->total_denda;
                $nilai_total[(int)$key->tanggal] = $key->total_bayar + $key->total_denda;
    			$nilai_uang[(int)$key->tanggal]  = $key->total_uang;
    		}
    		$dt_tanggal = array();
            $dt_nilai_bayar = array();
            $dt_nilai_denda = array();
            $dt_nilai_total = array();
            $dt_nilai_uang = array();
    		$tgl = $input['filter_tahun'].'-'.sprintf('%02d', $input['filter_bulan']).'-01';
    		for($i=1;$i<=date("t",strtotime($tgl));$i++){
    			$dt_tanggal[] = sprintf('%02d', $i);
    			$nlBayar = isset($nilai_bayar[$i]) ? $nilai_bayar[$i] : 0;
    			$dt_nilai_bayar[] = $nlBayar;

                $nlDenda = isset($nilai_denda[$i]) ? $nilai_denda[$i] : 0;
                $dt_nilai_denda[] = $nlDenda;

                $nlTotal = (isset($nilai_bayar[$i]) ? $nilai_bayar[$i] : 0) + (isset($nilai_denda[$i]) ? $nilai_denda[$i] : 0);
                $dt_nilai_total[] = $nlTotal;

                $nlUang = isset($nilai_uang[$i]) ? $nilai_uang[$i] : 0;
                $dt_nilai_uang[] = $nlUang;
    		}
			return response()->json(['status' => true, 'nilai_bayar' => $dt_nilai_bayar , 'nilai_denda' => $dt_nilai_denda , 'nilai_total' => $dt_nilai_total , 'nilai_uang' => $dt_nilai_uang , 'x_column' => $dt_tanggal]);
    	}else{
			return response()->json(['status' => true, 'nilai' => [] , 'bulan' => []]);
    	}
    }
    function getChartSemuaTransBulanan(Request $request){
        $input = $request->all();
        $bulan = [1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $kasir = Kasir::select(DB::raw('sum(total_bayar) as total_bayar'),DB::raw('sum(total_denda) as total_denda'),DB::raw('sum(total_uang) as total_uang'),DB::raw('MONTH(tanggal_dikembalikan) as bulan'))->where('status','kembali')->where(DB::raw('YEAR(tanggal_dikembalikan)'),date("Y"))->groupBy(DB::raw('MONTH(tanggal_dikembalikan)'));
        $nilai_bayar = array();
        $nilai_denda = array();
        $nilai_total = array();
        $nilai_uang = array();
        foreach ($kasir->get() as $key) {
            $nilai_bayar[(int)$key->bulan] = $key->total_bayar;
            $nilai_denda[(int)$key->bulan] = $key->total_denda;
            $nilai_total[(int)$key->bulan] = $key->total_bayar + $key->total_denda;
            $nilai_uang[(int)$key->bulan] = $key->total_uang;
        }
        $dt_bulan = array();
        $dt_nilai_bayar = array();
        $dt_nilai_denda = array();
        $dt_nilai_total = array();
        $dt_nilai_uang = array();
        foreach ($bulan as $key => $val) {
            $dt_bulan[] = $val;
            $nlBayar = isset($nilai_bayar[$key]) ? $nilai_bayar[$key] : 0;
            $dt_nilai_bayar[] = $nlBayar;

            $nlDenda = isset($nilai_denda[$key]) ? $nilai_denda[$key] : 0;
            $dt_nilai_denda[] = $nlDenda;

            $nlTotal = (isset($nilai_bayar[$key]) ? $nilai_bayar[$key] : 0) + (isset($nilai_denda[$key]) ? $nilai_denda[$key] : 0);
            $dt_nilai_total[] = $nlTotal;

            $nlUang = isset($nilai_uang[$key]) ? $nilai_uang[$key] : 0;
            $dt_nilai_uang[] = $nlUang;
        }
        return response()->json(['status' => true, 'nilai_bayar' => $dt_nilai_bayar , 'nilai_denda' => $dt_nilai_denda , 'nilai_total' => $dt_nilai_total , 'nilai_uang' => $dt_nilai_uang , 'x_column' => $dt_bulan]);
        
    }
    function getTotalTransaksi(Request $request){
    	$input = $request->all();
    	$jenis = $input['filter_jenis_chart'];
    	if ($jenis!='') {
    		$kasir = Kasir::select(DB::raw('sum(total_bayar) as total_bayar'),DB::raw('sum(total_denda) as total_denda'),DB::raw('sum(total_uang) as total_uang'));
    		if ($jenis=='tahunan') {
    			$kasir = $kasir->where(DB::raw('YEAR(tanggal_dikembalikan)'),$input['filter_tahun'])->first();
    		}else if ($jenis=='bulanan') {
    			$kasir = $kasir->where(DB::raw('YEAR(tanggal_dikembalikan)'),$input['filter_tahun']);
    			$kasir = $kasir->where(DB::raw('MONTH(tanggal_dikembalikan)'),$input['filter_bulan'])->first();
    		}
            $total_bayar = $kasir->total_bayar > 0 ? number_format($kasir->total_bayar,2) : 0;
            $total_denda = $kasir->total_denda > 0 ? number_format($kasir->total_denda,2) : 0;
            $total_total = number_format($kasir->total_bayar+$kasir->total_denda,2);
    		$total_uang  = $kasir->total_uang > 0 ? number_format($kasir->total_uang,2) : 0;
			return response()->json(['status' => true, 'total_bayar' =>  $total_bayar, 'total_denda' => $total_denda, 'total_total' => $total_total, 'total_uang' => $total_uang]);
    	}
		return response()->json(['status' => true, 'total_bayar' => 0 , 'total_denda' => 0, 'total_total' => 0, 'total_uang' => 0]);
    }
    public function getTotalDashboard(Request $request){
        $barang = Barang::count();
        $user = User::where('user_level_id','peminjam')->count();
        $transaksi = Kasir::where('status','kembali')->count();

        return response()->json(['status' => true, 'total_user' => $user , 'total_transaksi' => $transaksi, 'total_barang' => $barang]);
    }
}
