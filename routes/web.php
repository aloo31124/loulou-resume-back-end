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

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//個人資料
Route::get('/personalData','personalDataController@index');
Route::post('/personalData','personalDataController@insertPesonalDataInDB');
Route::delete('/personalData/delete/{personalData}','personalDataController@deletePesonalDataInDB');
Route::put('/personalData/edit/{personalData}','personalDataController@updatePesonalDataInDB');


////////////////////////////////////////////////////////////////////////////////////////////////////////////
//工作能力
Route::get('/workingAbility','workingAbilityController@index');
Route::post('/workingAbility','workingAbilityController@insertWorkingAbilityInDBAndReload');
Route::put('/workingAbility','workingAbilityController@updateWorkingAbilityInDBAndReload');
Route::delete('/workingAbility','workingAbilityController@deleteWorkingAbilityInDBAndReload');

Route::get('/workingAbilityTreeThisNodeNextLevel','workingAbilityController@buildWorkingAbilityCategoryTree_ThisNodeNextLevel');
Route::get('/workingAbilityContent','workingAbilityController@initalWorkingAbilityRightContentCard');
Route::get('/WorkingAbilityCategoryTitle','workingAbilityController@showWorkingAbilityCategoryTitle');
Route::get('/workingAbilityCategoryBakeToParent','workingAbilityController@findWorkingAbilityCategoryParentIdById');

Route::post('/workingAbilityCategory','workingAbilityController@insertWorkingAbilityCategoryInDB');
Route::put('/workingAbilityCategory','workingAbilityController@updateWorkingAbilityCategoryInDB');
Route::delete('/workingAbilityCategory','workingAbilityController@deleteWorkingAbilityCategoryInDB');

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//撰寫自傳
Route::get('/autobiography','autobiographyController@index');
Route::post('/autobiography','autobiographyController@insertAutobiographyChanpterInDB');
Route::put('/autobiography','autobiographyController@updateAutobiographyChanpterInDB');
Route::delete('/autobiography','autobiographyController@deleteAutobiographyChanpterInDB');
Route::put('/autobiographyChangeSort','autobiographyController@changeChapterSortInDB');

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//作品集

Route::get('/portfolio','portfolioController@index');
//初始左樹選單，或滑鼠點擊產生下一層
Route::get('/portfolioTreeMenuThisNodeBuildNextLevel','portfolioController@buildNextLevelByThisNodeCategoryForTreeMenu');
//點選左樹選單後，產生右內容頁
Route::get('/portfolioRightContentBuild','portfolioController@buildRightContent');