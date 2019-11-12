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

use App\Http\Controllers\QRScannerController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index');
Route::get('/scanqr', 'QRScannerController@index');
Route::post('/scanqr', 'HomeController@attendance_given');

Route::post('/genqr', 'QRGeneratorController@index');
Route::post('/done', 'HomeController@attendance_taken');
