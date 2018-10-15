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

  // profile developer TinhNT11
  Route::group(['prefix' => 'thong-tin-ca-nhan'], function() {
    Route::get('/', 'ProfileController@view')->name('user.profile.view');
    Route::get('/update/{id}', 'ProfileController@update')->name('user.profile.update');
    Route::post('/action/{id}', 'ProfileController@action')->name('user.profile.action');
  });
  
  // Add start ThangTGM 20181009: Quản lý nhân sự
  Route::group(['prefix' => 'nhansu'], function() {
    Route::get('/', 'AdminController@lstQLNS')->name('admin.qlnhansu');
    // Chờ ku Tính xong sẽ kế thừa
    
    
    Route::get('/detail', 'AdminController@createNS')->name('admin.qlnhansu.create');
    Route::get('/create', 'AdminController@createNS')->name('admin.qlnhansu.create');
    
    Route::get('/trans', 'AdminController@transDetail')->name('admin.trans.detail');
    Route::post('/getTransDetail', 'AdminController@getTransDetail')->name('admin.get.transdetail');
    
    Route::get('/withdraw', 'AdminController@withdraw')->name('admin.trans.withdraw');
    Route::post('/withdrawAction', 'AdminController@withdrawAction')->name('admin.withdraw.action');
    
    Route::get('/applytrans', 'AdminController@applytrans')->name('admin.trans.applytrans');
    Route::post('/applytransAction', 'AdminController@applytransAction')->name('admin.applytrans.action');
    Route::post('/applytransSearch', 'AdminController@applytransSearch')->name('admin.applytrans.search');
    
    Route::get('/commissionHis', 'AdminController@commissionHis')->name('admin.commission.history');
    Route::post('/commissionSearch', 'AdminController@commissionSearch')->name('admin.commission.search');
    Route::post('/commissionTree', 'AdminController@commissionTree')->name('admin.commission.tree');
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
    Route::get('/danh-sach-da-chot', 'DoanhThuController@doanhThuDaChot')->name('admin.doanhthu.index');
    Route::get('/chot-doanh-thu', 'DoanhThuController@action')->name('admin.doanhthu.action');
    Route::get('/chi-tiet/{id}', 'DoanhThuController@detail')->name('admin.doanhthu.detail');
    Route::get('/danh-sach-thang', 'DoanhThuController@doanhThuThang')->name('admin.doanhthu.thang');
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
      Route::post('/doanhThuDaChot', 'DoanhThuApi@danhThuDaChot')->name('api.doanhthu.dachot');
      Route::post('/doanhThuThang', 'DoanhThuApi@doanhThuThang')->name('api.doanhthu.thang');
      Route::post('/data', 'DoanhThuApi@dataChotDoanhThu')->name('api.doanhthu.data');
      Route::post('/action', 'DoanhThuApi@actionData')->name('api.doanhthu.action');
    });
  });

  Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {
    Route::group(['prefix' => 'hoa-hong'], function() {
      Route::post('/all', 'HoaHongApi@all')->name('api.hoahong.all');
    });
  });
  
});