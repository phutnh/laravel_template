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

    return Datatables::of($this->repository->query())->make();
  	return view('back.index', compact('template'));
  }
}
