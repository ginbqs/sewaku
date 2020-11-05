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

Route::resource('/barang','BarangController');
Route::get('/allBarang','BarangController@allBarang')->name('allBarang.barang');
Route::post('autocompleteBarang', 'BarangController@autocomplete')->name('autocompleteBarang.barang');

Route::resource('/kasir','KasirController');
Route::get('/allKasir','KasirController@allKasir')->name('allKasir.kasir');
Route::get('/kasir/editProduk/{id}','KasirController@editProduk')->name('editProduk.kasir');
Route::get('/kasir/editKasir/{id}','KasirController@editKasir')->name('editKasir.kasir');
Route::get('/kasir/getValidateVarian/{id}','KasirController@getValidateVarian')->name('getValidateVarian.kasir');
Route::get('/kasir/getNilai/{id}','KasirController@getNilai')->name('getNilai.kasir');
Route::post('/kasir/createKasirDetail','KasirController@createKasirDetail')->name('createKasirDetail.kasir');
Route::post('/kasir/updateKasirDetail/{id}','KasirController@updateKasirDetail')->name('updateKasirDetail.kasir');
Route::post('/kasir/selesai/{id}','KasirController@selesai')->name('selesai.kasir');

Route::resource('/kasir/kasirDetail','KasirDetailController');
Route::get('/allKasirDetail','KasirController@allKasirDetail')->name('allKasirDetail.kasirDetail');

