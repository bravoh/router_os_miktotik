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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();
Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/sandbox', 'HomeController@sandbox')->name('sandbox');

//Mikrotik
Route::group(['prefix'=>'mikrotik','as'=>'mikrotik.'],function (){
    Route::match(['get'],'/status','MirotikController@systemStatus')->name('status');
    Route::match(['get'],'/cron','MirotikController@cron')->name('cron');
});

Route::group(['prefix'=>'customers','as'=>'customers.'],function (){
    Route::match(['get'],'/','CustomerController@index')->name('index');
    Route::match(['post','get'],'/create','CustomerController@create')->name('create');
    Route::match(['post','get'],'/edit/{id}','CustomerController@edit')->name('edit');
    Route::match(['post','get'],'/delete/{id}','CustomerController@delete')->name('delete');
});
Route::group(['prefix'=>'transactions','as'=>'transactions.'],function (){
    Route::match(['get'],'/','TransactionController@index')->name('index');

});
Route::group(['prefix'=>'subscriptions','as'=>'subscriptions.'],function (){
    Route::match(['get'],'/','SubscriptionController@index')->name('index');

});
Route::group(['prefix'=>'sms','as'=>'sms.'],function (){
    Route::match(['get'],'/','SmsController@index')->name('index');
    Route::match(['get'],'/run-scheduled','SmsController@runScheduler')->name('run.scheduled');
});

Route::group(['prefix'=>'plans','as'=>'plans.'],function (){
    Route::match(['get'],'/','PlanController@index')->name('index');
    Route::match(['post','get'],'/{id}/edit','PlanController@edit')->name('edit');
    Route::match(['post'],'/delete','PlanController@delete')->name('delete');

    Route::group(['prefix'=>'hotspot','as'=>'hotspot.'],function (){
        Route::match(['post','get'],'/create','PlanController@hotspotCreate')->name('create');
    });

    Route::group(['prefix'=>'pppoe','as'=>'pppoe.'],function (){
        Route::match(['post','get'],'/create','PlanController@pppoeCreate')->name('create');
    });
});

Route::group(['prefix'=>'bandwidth','as'=>'bandwidth.'],function (){
    Route::match(['get'],'/index','BandwidthController@index')->name('index');
    Route::match(['post','get'],'/create','BandwidthController@create')->name('create');
    Route::match(['post','get'],'/{id}/edit','BandwidthController@edit')->name('edit');
    Route::match(['post'],'/delete','BandwidthController@delete')->name('delete');
});

Route::group(['prefix'=>'prepaid','as'=>'prepaid.'],function (){
    Route::match(['get'],'/','PrepaidController@index')->name('index');
    Route::match(['post','get'],'/create','PrepaidController@create')->name('create');
    Route::match(['post','get'],'/{id}/edit','PrepaidController@edit')->name('edit');
    Route::match(['post'],'/delete','PrepaidController@delete')->name('delete');
});

Route::group(['prefix' => '/'], function () {
    Voyager::routes();
});
