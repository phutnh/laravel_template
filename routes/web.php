<?php

//Site route
Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

// User register
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('user.register.index');
Route::post('/register', 'Auth\RegisterController@create')->name('user.register.create');

// Admin route
Route::group(['prefix' => 'cpanel', 'namespace' => 'AdminCP', 'middleware' => 'auth'], function() {
  Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

  Route::post('/markAsReadNotifications', 'AdminController@markAsReadNotifications')->name('admin.markAsReadNotifications');
  
  // Route quản lý phần trăm hoa hồng (tham số cấu hình)
  Route::group(['prefix' => 'tham-so'], function() {
    Route::get('/', 'ThamSoController@index')->name('admin.thamso.index');
    Route::get('/update/{id}', 'ThamSoController@update')->name('admin.thamso.update');
    Route::post('/action/{id}', 'ThamSoController@action')->name('admin.thamso.action');
  });

  // profile developer TinhNT11
  Route::group(['prefix' => 'thong-tin-ca-nhan'], function() {
    Route::get('/', 'ProfileController@view')->name('user.profile.view');
    Route::get('/update', 'ProfileController@update')->name('user.profile.update');
    Route::post('/action', 'ProfileController@action')->name('user.profile.action');
    Route::get('/doi-mat-khau', 'ProfileController@repass')->name('user.profile.repass');
    Route::post('/doi-mat-khau', 'ProfileController@repassaction')->name('user.profile.repassaction');
  });
  
  // Add start ThangTGM 20181009: Quản lý nhân sự
  Route::group(['prefix' => 'nhansu'], function() {
    Route::get('/', 'AdminController@lstQLNS')->name('admin.qlnhansu');
    Route::get('/notifications', 'AdminController@getNotifications')->name('admin.qlnhansu.notifications');
    Route::post('/delAll', 'AdminController@delAll')->name('admin.qlnhansu.delAll');
    
    Route::get('/detail/{id}', 'AdminController@viewUserDetail')->name('admin.qlnhansu.detail');
    Route::post('/detail/action/{id}', 'AdminController@actionUserDetail')->name('admin.detail.action');
    
    Route::get('/create', 'AdminController@viewCreateUser')->name('admin.qlnhansu.create');
    Route::post('/create/action', 'AdminController@createAction')->name('admin.qlnhansu.createAction');
    
    Route::get('/trans', 'AdminController@transDetail')->name('admin.trans.detail');
    Route::post('/getTransDetail', 'AdminController@getTransDetail')->name('admin.get.transdetail');
    
    Route::get('/withdraw', 'AdminController@withdraw')->name('admin.trans.withdraw');
    Route::post('/withdrawAction', 'AdminController@withdrawAction')->name('admin.withdraw.action');
    
    Route::get('/applytrans', 'AdminController@applytrans')->name('admin.trans.applytrans');
    Route::post('/applytransAction', 'AdminController@applytransAction')->name('admin.applytrans.action');
    Route::post('/applytransSearch', 'AdminController@applytransSearch')->name('admin.applytrans.search');
    
    Route::get('/commissionHis/{id?}', 'AdminController@commissionHis')->name('admin.commission.history');
    Route::post('/commissionSearch/{id?}', 'AdminController@commissionSearch')->name('admin.commission.search');
    Route::post('/commissionTree/{id?}', 'AdminController@commissionTree')->name('admin.commission.tree');
    
    Route::get('/contract/{id?}', 'AdminController@lstContract')->name('admin.qlnhansu.contract');
    Route::post('/contractSearch/{id?}', 'AdminController@contractSearch')->name('admin.contract.search');
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
      Route::post('/removeImage', 'HopDongApi@removeImage')->name('api.hopdong.remove.image');
      Route::post('/dataBieuDoHopDong', 'HopDongApi@dataBieuDoHopDong')->name('api.hopdong.bieudo');
    });
  });

  Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {
    Route::group(['prefix' => 'doanh-thu'], function() {
      Route::post('/doanhThuDaChot', 'DoanhThuApi@doanhThuDaChot')->name('api.doanhthu.dachot');
      Route::post('/doanhThuThang', 'DoanhThuApi@doanhThuThang')->name('api.doanhthu.thang');
      Route::post('/data', 'DoanhThuApi@dataChotDoanhThu')->name('api.doanhthu.data');
      Route::post('/action', 'DoanhThuApi@actionData')->name('api.doanhthu.action');
      Route::post('/dataBieuDoDoanhThu', 'DoanhThuApi@dataBieuDoDoanhThu')->name('api.doanhthu.bieudo');
    });
  });

  Route::group(['prefix' => 'api', 'namespace' => 'Api'], function() {
    Route::group(['prefix' => 'hoa-hong'], function() {
      Route::post('/all', 'HoaHongApi@all')->name('api.hoahong.all');
    });
  });
  
});