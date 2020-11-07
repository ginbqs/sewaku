<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes([
	'login' => false,
	'register' => false,
	'reset' => false,
	'logout' => false,
	'confirm' => false
]);
Route::get('/','AuthController@index');


Route::group([
	'namespace'	=> 'bqs\Admin',
	'prefix'	=> 'bqs_template',
	'as'		=> 'admin.',
	'middleware'=>'auth'],
	function(){
		require base_path('routes/backend/admin.php');
	}
);

Route::get('/bqs_template/login_bqs', 'AuthController@index')->name('login');
Route::post('post-login', 'AuthController@postLogin'); 
Route::get('/logout', 'AuthController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
