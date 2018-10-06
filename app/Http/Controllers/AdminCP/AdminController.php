<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DemoRequest;

class AdminController extends Controller
{
  public function dashboard()
  {
    $template['title'] = 'Test title';
    $template['title-breadcrumb'] = 'Test title';
    $template['breadcrumbs'] = [
      [
        'name' => 'Library',
        'link' => 'link',
        'active' => true
      ],
    ];

    return view('back._template.form', compact('template'));
  }

  // Sample function post
  public function postSample(DemoRequest $request)
  {
    # code...
  }
}
