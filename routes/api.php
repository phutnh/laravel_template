<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api\V1'], function() {
    
  Route::group(['prefix' => 'user'], function() {
    Route::get('/', 'UserApi@getUser')->name('api.get_user');
  });
  // Api hợp đồng
  Route::group(['prefix' => 'hopdong'], function() {
    Route::get('/all', 'HopDongApi@getAll')->name('api.hopdong.all');
  });
  
});