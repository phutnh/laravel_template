<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
  public function index()
  {
    if (Auth::check()) {
      return redirect()->route('admin.dashboard');
    } else {
      return redirect()->route('login');
    }
  }
  
}
