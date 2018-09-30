<?php

//Site route
Route::get('/', 'HomeController@index');
Auth::routes();


// Admin route
Route::group(['prefix' => 'admincp', 'namespace' => 'AdminCP'], function() {
  Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');
});