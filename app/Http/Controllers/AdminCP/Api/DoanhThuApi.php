<?php

namespace App\Http\Controllers\AdminCP\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\DoanhThuRepository;
use Datatables;

class DoanhThuApi extends Controller
{
  protected $repository = '';
  public function __construct(DoanhThuRepository $repository)
  {
  	$this->repository = $repository;
  }

  public function all(Request $request)
  {
  	$doanhthu = $this->repository->datatables($request);
  	return Datatables::of($doanhthu)
      ->editColumn('ngaychot', function($model) {
        return formatDateTimeData($model->ngaychot);
      })
      ->editColumn('sotien', function($model) {
        return formatMoneyData($model->sotien);
      })
      ->make(true);
  }
}