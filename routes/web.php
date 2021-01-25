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

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']], function()
{
//    Route::get('/', function () {
//        return view('dashboard');
//    });

    Route::get('test','testController@index')->name('test');

    Route::get('/','HomeController@index')->name('dashboard');

########################################### Start Grades Routes ##############################################
    Route::group(['namespace'=>'Grades'],function (){
        Route::get('Grades','gradesController@index')->name('grades.get');
        Route::post('Grades/store','gradesController@store')->name('grades.store');
    });
########################################### Start Grades Routes ##############################################

});




