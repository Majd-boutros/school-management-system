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
        Route::post('classes-filter','ClassroomsController@classesFilter')->name('classes.filter');
    });
########################################### Start ClassRooms Routes ##############################################

########################################### Start Sections Routes ##############################################
    Route::group(['namespace'=>'Sections'],function (){
        Route::get('sections','SectionsController@index')->name('section.get');
        Route::post('sections/store','SectionsController@store')->name('section.store');
        Route::get('grade/class/{grade_id}','SectionsController@getClassesByGradeId')->name('gradeClass.get');
        Route::post('sections/update','SectionsController@update')->name('section.update');
        Route::post('sections/delete','SectionsController@destroy')->name('section.destroy');
    });
########################################### Start Sections Routes ################################################

########################################### Start Parent Routes ################################################
    Route::view('add_parent','livewire.show_form')->name('parent.add');
########################################### End Parent Routes ################################################


});




