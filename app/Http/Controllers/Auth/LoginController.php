<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
  use AuthenticatesUsers;
  
  // protected $redirectTo = '/home';

  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }
  
  protected function authenticated($request, $user)
  {
    return redirect()->route('admin.dashboard');
  }

  public function showLoginForm()
  {
    return view('auth.login');
  }
  
  public function username()
  {
    return 'taikhoan';
  }
  
  protected function validateLogin($request)
  {
    $this->validate($request, 
    [
      $this->username() => 'required|string',
      $this->username() => Rule::exists('nhanvien')->where(function ($query) use ($request) {
          $query->where('taikhoan', $request->taikhoan);
          $query->where('trangthai', '<>', 2);
      }),
      'password' => 'required|string',
    ],
    [
      $this->username() . '.required' => 'Vui lòng nhập tài khoản',
      $this->username() . '.exists' => 'Tài khoản không hợp lệ',
      'password.required' => 'Vui lòng nhập mật khẩu'
    ]);
  }
}
