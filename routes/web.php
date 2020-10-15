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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');



Route::get('/', 'HomeController@index')->name('/');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/homes', 'Frontend\BarangController@index')->name('homes');

Route::resource('satuanpenjualan', 'Admin\SatuanPenjualanController');
Route::resource('satuanpembelian', 'Admin\SatuanPembelianController');
Route::resource('rak', 'Admin\RakController');
Route::resource('jenisbarang', 'Admin\JenisBarangController');
Route::resource('supplier', 'Admin\SupplierController');
Route::resource('barang', 'Admin\BarangController');
Route::resource('jenisbarang', 'Admin\JenisBarangController');

Route::resource('pembelian', 'Admin\PembelianController');
Route::get('pembelian/detail/{nomorFaktur}', 'Admin\PembelianController@detail');

Route::resource('detailpembelian', 'Admin\DetailPembelianController');

//penjualan
Route::get('/penjualan/trashed', 'Admin\PenjualanController@trashed')->name('penjualan.trashed');
Route::get('/penjualan/restore/{orderID}', 'Admin\PenjualanController@restore')->name('penjualan.restore');

Route::get('/penjualan/{orderID}/cancel', 'Admin\PenjualanController@cancel')->name('penjualan.get_cancel');
Route::put('/penjualan/cancel/{orderID}', 'Admin\PenjualanController@doCancel')->name('penjualan.cancel');
Route::post('/penjualan/complete/{orderID}', 'Admin\PenjualanController@doComplete')->name('penjualan.complete');
Route::resource('penjualan', 'Admin\PenjualanController');


Route::resource('shipments', 'Admin\ShipmentController');

Route::get('reports/revenue', 'Admin\ReportController@revenue');
Route::get('reports/product', 'Admin\ReportController@product');
Route::get('reports/inventory', 'Admin\ReportController@inventory');
Route::get('reports/payment', 'Admin\ReportController@payment');


///////
Route::resource('detailpenjualan', 'Admin\DetailPenjualanController');

Route::resource('persediaan', 'Admin\PersediaanController');
Route::get('/persediaan/{id}', 'Admin\PersediaanController@index');
Route::get('/persediaan/{id}/create', 'Admin\PersediaanController@create');
Route::post('/persediaan/store', 'Admin\PersediaanController@store');
Route::delete('/persediaan/hapus/{id}', 'Admin\PersediaanController@destroy');
Route::get('/persediaan/edit/{id}', 'Admin\PersediaanController@edit');
Route::post('/persediaan/update', 'Admin\PersediaanController@update');
Route::get('/persediaanperrak', 'Admin\PersediaanController@indexperrak')->name('persediaanperrak');

////front
Route::get('/front', 'Ecommerce\FrontController@index')->name('front.index');
Route::get('/product', 'Ecommerce\FrontController@product')->name('front.product');
Route::get('/category/{id}', 'Ecommerce\FrontController@categoryProduct')->name('front.category');
Route::get('/product/{id}', 'Ecommerce\FrontController@show')->name('front.show_product');

Route::post('cart', 'Ecommerce\CartController@addToCart')->name('front.cart');
Route::get('/cart', 'Ecommerce\CartController@listCart')->name('front.list_cart');
Route::post('/cart/update', 'Ecommerce\CartController@updateCart')->name('front.update_cart');

Route::get('/checkout', 'Ecommerce\CartController@checkout')->name('front.checkout');
Route::post('/checkout', 'Ecommerce\CartController@processCheckout')->name('front.store_checkout');
Route::get('/checkout/{invoice}', 'Ecommerce\CartController@checkoutFinish')->name('front.finish_checkout');




///endfront

//ezonefront

Route::get('/products', 'ProductController@index');
Route::get('/products/{id}', 'ProductController@show');
Route::get('/products/quick-view/{id}', 'ProductController@quickView');

Route::get('/carts', 'CartController@index');
Route::get('/carts/remove/{cartID}', 'CartController@destroy');
Route::post('/carts', 'CartController@store');
Route::post('/carts/update', 'CartController@update');

Route::get('orders/checkout', 'OrderController@checkout');
Route::post('orders/checkout', 'OrderController@doCheckout');
Route::post('orders/shipping-cost', 'OrderController@shippingCost');
Route::post('orders/set-shipping', 'OrderController@setShipping');
Route::get('orders/received/{orderID}', 'OrderController@received');
Route::get('orders/cities', 'OrderController@cities');
Route::get('orders', 'OrderController@index');
Route::get('orders/{orderID}', 'OrderController@show');

Route::post('payments/notification', 'PaymentController@notification');
Route::get('payments/completed', 'PaymentController@completed');
Route::get('payments/failed', 'PaymentController@failed');
Route::get('payments/unfinish', 'PaymentController@unfinish');


Route::get('profile', 'ProfileController@index');
Route::post('profile', 'ProfileController@update');
//endezonefront