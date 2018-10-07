<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
  use ResetsPasswords;

  protected $redirectTo = '';

  public function __construct()
  {
    $this->middleware('guest');
    $this->redirectTo = route('admin.dashboard');
  }
  
  protected function validationErrorMessages()
  {
    return [
      'email.required' => 'Vui lòng nhập email',
      'email.email' => 'Vui lòng nhập email',
      'password.required' => 'Vui lòng nhập mật khẩu',
      'password.confirmed' => 'Mật khẩu nhập lại không khớp',
      'password.min' => 'Mật khẩu phải từ 6 ký tự'
    ];
  }
}
