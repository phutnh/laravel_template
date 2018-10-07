<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use App\Repositories\Repository\UserRepository;

class Template extends Controller
{
  protected $repository = '';

  public function __construct(UserRepository $userRepository)
  {
    $this->repository = $userRepository;
  }

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
    
  	return view('back.index', compact('template'));
  }
}

/*
class FunctoionController extends Controller
{
  public function index()
  {
    $template['title'] = 'Test title';
    $template['title-breadcrumb'] = 'Test title';
    $template['form-datatable'] = true // Hiển thị table của dữ liệu sử dụng datatable
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
*/