<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
  use SendsPasswordResetEmails;
  
  public function __construct()
  {
    $this->middleware('guest');
  }

  public function showLinkRequestForm()
  {
    return view('auth.passwords.email');
  }
  
    
  protected function validateEmail($request)
  {
    $this->validate($request,
    [
      'email' => 'required|email'
    ],
    [
     'email.required' => 'Vui lòng nhập địa chỉ email',
     'email.email' => 'Vui lòng nhập địa chỉ email',
    ]);
  }
}
