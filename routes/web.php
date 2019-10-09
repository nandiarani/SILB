<?php

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

Route::get('/', function () {
    return view('auth/login');
})->middleware('guest');

Auth::routes(['verify'=>true]);

Route::get('home', 'HomeController@index')->name('home')->middleware(['auth','verified','activated']);
Route::get('forecast','HomeController@forecast');
Route::post('report', 'HomeController@report')->name('reportDetail');//->middleware(['auth','verified','activated']);
Route::get('fetchChart/{month}/{year?}', 'HomeController@fetchChart');//->middleware(['auth','verified','activated']);
Route::get('fetchMonth/{year}','HomeController@fetchMonth');

Route::resource('modal', 'ModalController')->middleware(['auth','owner']);
Route::resource('tarif', 'MstHargaIkanController')->middleware(['auth','owner']);
Route::resource('jenis_pengeluaran', 'JenisPengeluaranController')->middleware(['auth','owner']);
Route::resource('pegawai', 'PegawaiController')->middleware(['auth','owner']);
Route::resource('pengeluaran', 'TrnPengeluaranController')->middleware('auth');
Route::resource('penjualan', 'TrnPenjualanController')->middleware('auth');

Route::get('penjualan/fetch/{date}','TrnPenjualanController@fetch');
Route::get('penjualan/getprice/{id_ukuran}','TrnPenjualanController@getprice');
    
Route::get('penjualan/detil/{id}','TrnPenjualanController@indexDetil')->name('detil.index')->middleware('auth');
Route::get('detil/create/{id}','TrnPenjualanController@createDetil')->name('detil.create')->middleware('auth');
Route::post('detil','TrnPenjualanController@storeDetil')->name('detil.store')->middleware('auth');

Route::get('detil/{id}','TrnPenjualanController@editDetil')->name('detil.edit')->middleware('auth');
Route::match(['put', 'patch'],'detil','TrnPenjualanController@updateDetil')->name('detil.update')->middleware('auth');

Route::delete('detil/{id}','TrnPenjualanController@destroyDetil')->name('detil.destroy')->middleware('auth');







