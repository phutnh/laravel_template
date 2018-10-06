<?php

//Site route
Route::get('/', 'HomeController@index')->name('home');
Auth::routes();


// Admin route
Route::group(['prefix' => 'admincp', 'namespace' => 'AdminCP'], function() {
  Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

  //Route Sample post
  Route::post('/sample', 'AdminController@postSample')->name('admin.sample.post');
});