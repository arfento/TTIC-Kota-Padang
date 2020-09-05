<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
    
Route::get('/home', 'HomeController@index')->name('home');

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
// Route::post('satuanpembelian/delid', 'SatuanPembelianController@delid');
    

// Route::get('rak/{id_rak:slug}/{id_persediaan:slug}', 'RakController@show')->name('rak.show');