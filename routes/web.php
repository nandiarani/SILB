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

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('modal', 'ModalController')->middleware('auth');
Route::resource('tarif', 'MstTarifByUkuranController')->middleware('auth');
Route::resource('jenis_pengeluaran', 'JenisPengeluaranController')->middleware('auth');






