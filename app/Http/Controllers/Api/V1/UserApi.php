<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use App\Repositories\Repository\UserRepository;

class UserApi extends Controller
{
  protected $repository = '';

  public function __construct(UserRepository $userRepository)
  {
    $this->repository = $userRepository;
  }

  public function getUser()
  {
  	$query = $this->repository->query();
  	return Datatables::of($query)->make(true);
  }
}
