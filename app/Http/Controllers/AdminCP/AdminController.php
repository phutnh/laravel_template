<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

  	return view('back.index', compact('template'));
  }
}
