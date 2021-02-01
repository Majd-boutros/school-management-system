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
        Route::post('Grades/update','gradesController@update')->name('grades.update');
        Route::post('Grades/delete','gradesController@destroy')->name('grades.destroy');
    });
########################################### Start Grades Routes ##############################################

########################################### Start ClassRooms Routes ##############################################
    Route::group(['namespace'=>'Classrooms'],function (){
        Route::get('classes','ClassroomsController@index')->name('class.get');
        Route::post('class/store','ClassroomsController@store')->name('class.store');
        Route::post('class/update','ClassroomsController@update')->name('class.update');
        Route::post('class/delete','ClassroomsController@destroy')->name('class.destroy');
    });
########################################### Start ClassRooms Routes ##############################################

});




