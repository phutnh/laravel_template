<?php

//Site route
Route::get('/', 'HomeController@index')->name('home');
Auth::routes();


// Admin route
Route::group(['prefix' => 'cpanel', 'namespace' => 'AdminCP', 'middleware' => 'auth'], function() {
  Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

  //Route Sample post
  Route::post('/sample', 'AdminController@postSample')->name('admin.sample.post');
  
  // Route quản lý phần trăm hoa hồng (tham số cấu hình)
  Route::group(['prefix' => 'tham-so'], function() {
    Route::get('/', 'ThamSoController@index')->name('admin.thamso.index');
    Route::get('/update/{id}', 'ThamSoController@update')->name('admin.thamso.update');
    Route::post('/action/{id}', 'ThamSoController@action')->name('admin.thamso.action');
  });

  
  // Add start ThangTGM 20181009: Quản lý nhân sự
  Route::group(['prefix' => 'nhansu'], function() {
    Route::get('/', 'AdminController@lstQLNS')->name('admin.qlnhansu');
    // Chờ ku Tính xong sẽ kế thừa
    // profile developer TinhNT11
    Route::get('/thong-tin-nhan-su/{id}', 'ProfileController@view')->name('admin.profile.view');
    // -------------------------
    
    Route::get('/detail', 'AdminController@createNS')->name('admin.qlnhansu.create');
    Route::get('/create', 'AdminController@createNS')->name('admin.qlnhansu.create');
    
    Route::get('/trans', 'AdminController@transDetail')->name('admin.trans.detail');
    Route::post('/getTransDetail', 'AdminController@getTransDetail')->name('admin.get.transdetail');
    
    Route::get('/withdraw', 'AdminController@withdraw')->name('admin.trans.withdraw');
    Route::post('/withdrawAction', 'AdminController@withdrawAction')->name('admin.withdraw.action');
    
    Route::get('/applytrans', 'AdminController@applytrans')->name('admin.trans.applytrans');
    Route::post('/applytransAction', 'AdminController@applytransAction')->name('admin.applytrans.action');
    Route::post('/applytransSearch', 'AdminController@applytransSearch')->name('admin.applytrans.search');
  });
  // Add end
  
  // Route hợp đồng
  Route::group(['prefix' => 'hop-dong'], function() {
    Route::get('/', 'HopDongController@index')->name('admin.hopdong.index');
    Route::get('/them-moi', 'HopDongController@create')->name('admin.hopdong.create');
    Route::get('/chinh-sua/{id}', 'HopDongController@update')->name('admin.hopdong.update'); 
  });

  // Route doanh thu
  Route::group(['prefix' => 'doanh-thu'], function() {
    Route::get('/', 'DoanhThuController@index')->name('admin.doanhthu.index');
    Route::get('/chot-doanh-thu', 'DoanhThuController@action')->name('admin.doanhthu.action');
  });
  
  
  // API Request action
  Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {
    Route::group(['prefix' => 'hop-dong'], function() {
      Route::post('/all', 'HopDongApi@all')->name('api.hopdong.all');
      Route::post('/create', 'HopDongApi@create')->name('api.hopdong.create');
      Route::post('/update/{id}', 'HopDongApi@update')->name('api.hopdong.update');
      Route::post('/action', 'HopDongApi@actionData')->name('api.hopdong.action');
    });
  });

  Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {
    Route::group(['prefix' => 'doanh-thu'], function() {
      Route::post('/all', 'DoanhThuApi@all')->name('api.doanhthu.all');
    });
  });
  
});