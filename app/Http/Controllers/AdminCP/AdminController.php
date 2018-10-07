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
    $template['form-datatable'] = true; // Hiển thị table của dữ liệu sử dụng datatable
    $template['breadcrumbs'] = [
      [
        'name' => 'Library',
        'link' => 'link',
        'active' => true
      ],
    ];
    return view('back.index', compact('template')); // Giao diện sample table
    // return view('back._template.form', compact('template')); // Giao diện samle form
  }

  // Sample function post
  public function postSample(DemoRequest $request)
  {
    # code...
  }
}
