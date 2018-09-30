<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'user', 'namespace' => 'Api\V1'], function() {
  Route::get('/', 'UserApi@getUser')->name('api.get_user');
});