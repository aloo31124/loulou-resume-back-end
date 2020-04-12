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

Route::get('/personalData','personalDataController@index');
Route::post('/personalData','personalDataController@insertPesonalDataInDB');
Route::delete('/personalData/{personalData}','personalDataController@deletePesonalDataInDB');
// delete 路由要放 model的名稱

//Route::get('/personalData/{personalData}','personalDataController@deletePesonalDataInDB');
///comments/{comment}/edit