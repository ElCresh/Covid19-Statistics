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
Route::get('/nations/ita', 'NationController@statistics_italy')->name('nation.statistics');
Route::get('/nations/{sigla}', 'NationController@statistics')->name('nation.statistics');
Route::get('/provinces/{sigla}', 'ProvinceController@statistics')->name('province.statistics');
Route::get('/regions/{sigla}', 'RegionController@statistics')->name('region.statistics');
