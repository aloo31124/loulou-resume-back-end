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
    //return view('welcome');
    return view('index');
});

Route::get('/personalData','personalDataController@index');
Route::post('/personalData','personalDataController@insertPesonalDataInDB');
Route::delete('/personalData/delete/{personalData}','personalDataController@deletePesonalDataInDB');
Route::put('/personalData/edit/{personalData}','personalDataController@updatePesonalDataInDB');

Route::get('/workingAbility','workingAbilityController@index');
Route::post('/workingAbility','workingAbilityController@insertWorkingAbilityInDB');
Route::post('/workingAbilityTreeOneNodeNextLevel','workingAbilityController@showWorkingAbilityCategory_TreeViewOneNodeNextLevel');
Route::get('/workingAbilityContent','workingAbilityController@buildWorkingAbilityRightContentCard');
Route::get('/WorkingAbilityCategoryTitle','workingAbilityController@showWorkingAbilityCategoryTitle');