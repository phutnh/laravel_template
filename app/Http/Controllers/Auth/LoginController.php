<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        'password' => 'required|string',
      ],
      [
        $this->username() . '.required' => 'Vui lòng nhập tài khoản',
        'password.required' => 'Vui lòng nhập mật khẩu'
      ]);
    }
}
