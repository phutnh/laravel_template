<?php

//Site route
Route::get('/', 'HomeController@index')->name('home');
Auth::routes();


// Admin route
Route::group(['prefix' => 'cpanel', 'namespace' => 'AdminCP', 'middleware' => 'auth'], function() {
  Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

  //Route Sample post
  Route::post('/sample', 'AdminController@postSample')->name('admin.sample.post');
  
  // Route hợp đồng
  Route::group(['prefix' => 'hop-dong'], function() {
    Route::get('/', 'HopDongController@index')->name('admin.hopdong.index');
    Route::get('/them-moi', 'HopDongController@create')->name('admin.hopdong.create');
    Route::post('/them-moi', 'HopDongController@create')->name('admin.hopdong.create');
  });


    // API Request action
    Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {
      Route::get('/all', 'HopDongApi@all')->name('api.hopdong.all');
      Route::post('/create', 'HopDongApi@create')->name('api.hopdong.create');
    });
  
});