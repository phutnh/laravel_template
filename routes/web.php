<?php

//Site route
Route::get('/', 'HomeController@index')->name('home');
Auth::routes();


// Admin route
Route::group(['prefix' => 'cpanel', 'namespace' => 'AdminCP', 'middleware' => 'auth'], function() {
  Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

  //Route Sample post
  Route::post('/sample', 'AdminController@postSample')->name('admin.sample.post');
});