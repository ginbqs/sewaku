<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\ProdukImage;
use App\Models\FavoriteProduk;
use App\Models\Masterdata\UkuranProduk;

class FrontEndController extends Controller
{
    function index(Request $request){
    	return view('frontend_bqs.home');
    }
    function getFavoriteHome(Request $request){
    	$dtDefault = [
			[
				"img"	=> "frontEnd_v1/img/bg-img/1.jpg",
				"harga"	=> "-",
				"nama"	=> "DEMO 1",
			],
			[
				"img"	=> "frontEnd_v1/img/bg-img/2.jpg",
				"harga"	=> "-",
				"nama"	=> "DEMO 2",
			],
			[
				"img"	=> "frontEnd_v1/img/bg-img/3.jpg",
				"harga"	=> "-",
				"nama"	=> "DEMO 3",
			],
			[
				"img"	=> "frontEnd_v1/img/bg-img/4.jpg",
				"harga"	=> "-",
				"nama"	=> "DEMO 4",
			],
			[
				"img"	=> "frontEnd_v1/img/bg-img/5.jpg",
				"harga"	=> "-",
				"nama"	=> "DEMO 5",
			],
			[
				"img"	=> "frontEnd_v1/img/bg-img/6.jpg",
				"harga"	=> "-",
				"nama"	=> "DEMO 6",
			],
			[
				"img"	=> "frontEnd_v1/img/bg-img/7.jpg",
				"harga"	=> "-",
				"nama"	=> "DEMO 7",
			],
			[
				"img"	=> "frontEnd_v1/img/bg-img/8.jpg",
				"harga"	=> "-",
				"nama"	=> "DEMO 8",
			],
			[
				"img"	=> "frontEnd_v1/img/bg-img/9.jpg",
				"harga"	=> "-",
				"nama"	=> "DEMO 9",
			]
		];
		$input 		= $request->all();
		$search  	= $input['mySearch'];
		$getData 	= FavoriteProduk::select('*');
		if (isset($search) && $search!='' && $search!='null' && $search!=null) {
			$getData	= $getData->where('nama','like','%'.$search.'%');
		}
		$dtFavorite = $getData->exists() ? $getData->get() : [];
		return response()->json(['status' => 'true', 'favorite' => $dtDefault, 'data' => $dtFavorite]);
    }
    function ProdukDetail($id){
    	$menu = [
    		'menu_title'		=> 'Casing',
    		'menu_sub_title'	=> 'Hp Xioami'
    	];
    	$data = Produk::where('id',$id)->first();
    	$dtIMG = ProdukImage::where('produk_id',$id)->get();
    	$dt_ukuran = UkuranProduk::where('jenis_id',$data['jenis_id'])->get();

    	return view('frontend_bqs.produk_detail',compact('menu','data','dtIMG','dt_ukuran'));
    }
}

