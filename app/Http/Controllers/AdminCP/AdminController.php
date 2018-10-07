<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DemoRequest;

class AdminController extends Controller
{
  public function dashboard()
  {
    $template['title'] = 'Quản lý';
    $template['title-breadcrumb'] = 'Quản lý';
    $template['breadcrumbs'] = [
      [
        'name' => 'Quản lý',
        'link' => '',
        'active' => true
      ],
    ];
    return view('back.index', compact('template'));
  }

  // Sample function post
  public function postSample(DemoRequest $request)
  {
    # code...
  }
}
