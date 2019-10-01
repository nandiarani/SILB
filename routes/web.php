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

Route::get('/report', 'HomeController@report')->middleware(['auth','verified','activated']);
Route::get('/fetchChart', 'HomeController@fetchChart')->middleware(['auth','verified','activated']);
Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth','verified','activated']);
Route::resource('modal', 'ModalController')->middleware(['auth','owner']);
Route::resource('tarif', 'MstHargaIkanController')->middleware(['auth','owner']);
Route::resource('jenis_pengeluaran', 'JenisPengeluaranController')->middleware(['auth','owner']);
Route::resource('pegawai', 'PegawaiController')->middleware(['auth','owner']);

Route::resource('pengeluaran', 'TrnPengeluaranController')->middleware('auth');
Route::resource('penjualan', 'TrnPenjualanController')->middleware('auth');
Route::get('penjualan/fetch/{date}','TrnPenjualanController@fetch');
Route::get('penjualan/getdata/{id_ukuran}','TrnPenjualanController@getdata');
    







