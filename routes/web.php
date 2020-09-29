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
Route::get('pembelian/detail/{nomorFaktur}', 'PembelianController@detail');

Route::resource('detailpembelian','DetailPembelianController');
Route::resource('penjualan','PenjualanController');
Route::resource('detailpenjualan','DetailPenjualanController');

Route::resource('persediaan','PersediaanController');
Route::get('/persediaan/{id}', 'PersediaanController@index');
Route::get('/persediaan/{id}/create','PersediaanController@create');
Route::post('/persediaan/store','PersediaanController@store');
Route::delete('/persediaan/hapus/{id}','PersediaanController@destroy');
Route::get('/persediaan/edit/{id}','PersediaanController@edit');
Route::post('/persediaan/update','PersediaanController@update');
Route::get('/persediaanperrak', 'PersediaanController@indexperrak')->name('persediaanperrak');

Route::get('/perkembangansiswa/{id}/siswa_perkelas', 'PersediaanController@getsiswaPerkelas');



Route::get('/front', 'Ecommerce\FrontController@index')->name('front.index');
Route::get('/product', 'Ecommerce\FrontController@product')->name('front.product');
Route::get('/category/{slug}', 'Ecommerce\FrontController@categoryProduct')->name('front.category');
Route::get('/product/{slug}', 'Ecommerce\FrontController@show')->name('front.show_product');

Route::post('cart', 'Ecommerce\CartController@addToCart')->name('front.cart');
Route::get('/cart', 'Ecommerce\CartController@listCart')->name('front.list_cart');
Route::post('/cart/update', 'Ecommerce\CartController@updateCart')->name('front.update_cart');

Route::get('/checkout', 'Ecommerce\CartController@checkout')->name('front.checkout');
Route::post('/checkout', 'Ecommerce\CartController@processCheckout')->name('front.store_checkout');
Route::get('/checkout/{invoice}', 'Ecommerce\CartController@checkoutFinish')->name('front.finish_checkout');






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