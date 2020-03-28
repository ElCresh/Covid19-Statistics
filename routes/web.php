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

Route::get('/', function () {
    return view('welcome');
});

Route::view('/regions', 'regions.list')->name('regions');
Route::view('/provinces', 'provinces.list')->name('provinces');
Route::get('/provinces/{sigla}', 'ProvinceController@statistics')->name('province.statistics');
