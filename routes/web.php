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

// Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Route::get('/inicio', function () {
//     return view('administrador');
// })->middleware('auth');

//Routes Adm7inistrador
Route::get('index-admin', 'AdministradorController@index')->name('index.admin')->middleware('auth');
// Route::get('getListado/{file}', 'AdministradorController@cargarListado')->name('listado.proveedores');
Route::post('cargarFile', 'AdministradorController@cargarListado')->name('listado.proveedores');
Route::get('getListado', 'AdministradorController@getListado')->name('listado.proveedores.get');


//Route sin rol
Route::get('index-proveedor', 'ProveedorController@index')->name('index.proveedor')->middleware('auth');
Route::post('store-proveedor','AdministradorController@store')->name('store.proveedor');
Route::post('delete-proveedor','AdministradorController@delete')->name('delete.proveedor');

Route::get('/home', 'HomeController@index')->name('home');
