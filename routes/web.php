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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'Schedule\ScheduleController@all_schedules_get');
Route::post('/addconfirm', 'Schedule\ScheduleController@confirm_add_schedule');
Route::post('/done', 'Schedule\ScheduleController@dojob');
Route::post('/removeconfirm', 'Schedule\ScheduleController@confirm_remove_schedule');
Route::post('/update', 'Schedule\ScheduleController@show_update_form');
Route::post('/updateconfirm', 'Schedule\ScheduleController@confirm_update_schedule');
Route::get('/weekly', 'Schedule\ScheduleController@weekly_schedule');
Route::get('/monthly', 'Schedule\ScheduleController@monthly_schedule');
