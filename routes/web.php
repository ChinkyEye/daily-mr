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

Auth::routes(['register' => false]);

Route::namespace('Backend')->prefix('home')->name('admin.')->middleware(['admin','auth'])->group(function(){
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('staff/search', 'StaffController@StaffSearch')->name('staffwork.search');
    Route::resource('/staff', 'StaffController');
    Route::resource('/project', 'ProjectController');
    Route::get('/project/active/{id}', 'ProjectController@isActive')->name('project.active');
     //mediator
    Route::resource('/mediator', 'MediatorController');
    //contact
    Route::resource('/contact', 'ContactController');
    Route::post('/contact/getContactList', 'ContactController@getContactList')->name('getContactList');
    //client
    Route::resource('/client', 'ClientController');
    Route::get('/client/active/{id}', 'ClientController@isActive')->name('client.active');
    Route::get('/client/addinformation/{id}', 'ClientController@addinformation')->name('client.addinformation');
    Route::post('/client/storeinformation', 'ClientController@storeinformation')->name('client.storeinformation');

    Route::put('host/renewdate','HostController@updateDate')->name('updatedate');
    Route::resource('host', 'HostController');
    Route::get('client/host/{id}','HostController@addHost')->name('client.host');

    Route::resource('/clientmeeting', 'ClientmeetingController');

});
Route::namespace('Staff')->prefix('staff')->name('staff.')->middleware(['staff','auth'])->group(function(){
    Route::get('/', 'HomeController@index')->name('home');
    //client
    Route::resource('/client', 'ClientController');
    Route::get('/client/active/{id}', 'ClientController@isActive')->name('client.active');
    Route::get('/client/addinformation/{id}', 'ClientController@addinformation')->name('client.addinformation');
    Route::post('/client/storeinformation', 'ClientController@storeinformation')->name('client.storeinformation');
     Route::resource('/clientmeeting', 'ClientmeetingController');
    //mediator
    Route::resource('/mediator', 'MediatorController');
    Route::get('/mediator/active/{id}', 'MediatorController@isActive')->name('mediator.active');
    Route::post('/mediator/getMediatorList', 'MediatorController@getMediatorList')->name('getMediatorList');
    //Schedule
    Route::post('schedule/store/{id}', 'ScheduleController@store')->name('storeschedule');
    Route::get('schedule/addschedule','ScheduleController@addschedule')->name('addschedule');
    //contact
    Route::resource('/contact', 'ContactController');
    Route::post('/contact/getContactList', 'ContactController@getContactList')->name('getContactList');

});
