<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;


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
    return view('welcome');
});

Auth::routes();
    
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/homes', 'Frontend\BarangController@index')->name('homes');

Route::resource('satuanpenjualan','SatuanPenjualanController');
Route::resource('satuanpembelian','SatuanPembelianController');
Route::resource('rak','RakController');
Route::resource('jenisbarang','JenisBarangController');
Route::resource('supplier','SupplierController');
Route::resource('barang','BarangController');
Route::resource('jenisbarang','JenisBarangController');
Route::resource('pembelian','PembelianController');
Route::resource('detailpembelian','DetailPembelianController');
Route::resource('penjualan','PenjualanController');
Route::resource('detailpenjualan','DetailPenjualanController');
Route::resource('persediaan','PersediaanController');

Route::resource('barangs','Frontend\BarangController');
// Route::resource('history','Frontend\HistoryController');
// Route::resource('pesan','Frontend\PesanController');
Route::get('pesan/{id}', 'Frontend\PesanController@index');
Route::post('pesan/{id}', 'Frontend\PesanController@pesan');
//checkout
Route::get('check-out', 'PesanController@check_out');
Route::delete('check-out/{id}', 'PesanController@delete');
//konfirmasi
Route::get('konfirmasi-check-out', 'PesanController@konfirmasi');
//profile
Route::get('profile', 'Frontend\ProfileController@index');
Route::post('profile', 'Frontend\ProfileController@update');
//history
Route::get('history', 'HistoryController@index');
Route::get('history/{id}', 'HistoryController@detail');

// Route::resource('profile','frontend\ProfileController');
// Route::post('satuanpembelian/delid', 'SatuanPembelianController@delid');
    

// Route::get('rak/{id_rak:slug}/{id_persediaan:slug}', 'RakController@show')->name('rak.show');