<?php

namespace App\Http\Controllers\AdminCP\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\HoaHongRepository;
use Datatables;

class HoaHongApi extends Controller
{
  protected $repository = '';

  public function __construct(HoaHongRepository $repository)
  {
  	$this->repository = $repository;
  }

  public function all(Request $request)
  {
  	$hoahong = $this->repository->datatables($request);
  	return Datatables::of($hoahong)
      ->editColumn('giatri', function($model) {
        return formatMoneyData($model->giatri);
      })
      ->editColumn('created_at', function($model) {
        return formatDateTimeData($model->created_at);
      })
      ->make(true);
  }
}