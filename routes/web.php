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
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::prefix('bagian')->group(function () {
        Route::get('/', 'BagianController@index')->name('bagian.index');
        Route::get('/tambah', 'BagianController@tambah')->name('bagian.tambah');
        Route::post('/simpan', 'BagianController@simpan')->name('bagian.simpan');
    });
    Route::prefix('bonus')->group(function () {
        Route::get('/', 'BonusController@index')->name('bonus.index');
        Route::get('/tambah', 'BonusController@tambah')->name('bonus.tambah');
        Route::post('/simpan', 'BonusController@simpan')->name('bonus.simpan');
    });
    Route::prefix('transaksi')->group(function () {
        Route::get('/', 'TransaksiController@index')->name('transaksi.index');
        Route::get('/tambah', 'TransaksiController@tambah')->name('transaksi.tambah');
        Route::post('/simpan', 'TransaksiController@simpan')->name('transaksi.simpan');
    });
    Route::prefix('profile')->group(function () {
        Route::get('/', 'ProfileController@index')->name('profile.index');
        Route::post('/update', 'ProfileController@update')->name('profile.update');
    });
});
