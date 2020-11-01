<?php
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('config','Panel\ConfigurasiController');
Route::get('/allConfig','Panel\ConfigurasiController@allConfig')->name('allConfig.config');
Route::post('autocompleteConfig', 'Panel\ConfigurasiController@autocomplete')->name('autocompleteConfig.config');

Route::resource('users','Panel\UserController');
Route::get('/allUser','Panel\UserController@allUser')->name('allUser.users');
Route::post('autocompleteUsers', 'Panel\UserController@autocomplete')->name('autocompleteUsers.users');
Route::get('/export','Panel\UserController@export')->name('export');
Route::post('autocompleteProvinsi', 'Panel\UserController@autocomplete')->name('autocompleteProvinsi.provinsi');
Route::post('autocompleteKota', 'Panel\UserController@autocomplete')->name('autocompleteKota.kota');
Route::post('autocompleteKecamatan', 'Panel\UserController@autocomplete')->name('autocompleteKecamatan.kecamatan');
Route::post('autocompleteDesa', 'Panel\UserController@autocomplete')->name('autocompleteDesa.desa');

Route::resource('level','Panel\LevelController');
Route::get('/allLevel','Panel\LevelController@allLevel')->name('allLevel.level');
Route::post('autocompleteLevel', 'Panel\LevelController@autocomplete')->name('autocompleteLevel.level');

Route::resource('/produk','ProdukController');
Route::get('/allProduk','ProdukController@allProduk')->name('allProduk.produk');
Route::get('/cekChild/{id}','ProdukController@cekChild')->name('cekChild.produk');
Route::resource('/produkDetail','ProdukDetailController');
Route::get('/allProdukDetail','ProdukDetailController@allProdukDetail')->name('allProdukDetail.produk');

Route::resource('/kasir','KasirController');
Route::get('/allKasir','KasirController@allKasir')->name('allKasir.kasir');
Route::get('/allKeranjang','KasirController@allKeranjang')->name('allKeranjang.kasir');
Route::get('/allProdukKasir','KasirController@allProduk')->name('allProdukKasir.kasir');
Route::post('/cekKasirAbsen','KasirController@cekKasirAbsen')->name('cekKasirAbsen.kasir');
Route::post('/bukaKasir','KasirController@bukaKasir')->name('bukaKasir.kasir');
Route::get('/pembelianProduk/{id}','KasirController@pembelianProduk')->name('pembelianProduk.kasir');
Route::get('/keranjangProduk/{id}','KasirController@keranjangProduk')->name('keranjangProduk.kasir');
Route::post('/createPembelian','KasirController@createPembelian')->name('createPembelian.kasir');
Route::get('/getKeranjang','KasirController@getKeranjang')->name('getKeranjang.kasir');
Route::post('/checkOut','KasirController@checkOut')->name('checkOut.kasir');
Route::get('/hitungKasir','KasirController@hitungKasir')->name('hitungKasir.kasir');
Route::post('/tutupKasir','KasirController@tutupKasir')->name('tutupKasir.kasir');
Route::get('/checkOutHp','KasirController@checkOutHp')->name('checkOutHp.kasir');
Route::get('/allPaket','KasirController@allPaket')->name('allPaket.kasir');
Route::get('/pembelianPaket/{id}','KasirController@pembelianPaket')->name('pembelianPaket.kasir');
Route::post('/createPembelianPaket','KasirController@createPembelianPaket')->name('createPembelianPaket.kasir');
Route::post('/print_pembelian','KasirController@print_pembelian')->name('print_pembelian.kasir');
Route::get('/getValidateVarian/{id}','KasirController@getValidateVarian')->name('getValidateVarian.kasir');
