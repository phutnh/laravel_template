<?php

namespace App\Http\Controllers\AdminCP\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\HopDongRepository;
use Datatables;
use DateTime;
use App\Http\Requests\CreateHopDongRequest;

class HopDongApi extends Controller
{
  protected $repository = '';

  public function __construct(HopDongRepository $repository)
  {
    $this->repository = $repository;
  }
  
  public function all()
  {
  	$query = $this->repository->query();
  	return Datatables::of($query)->make(true);
  }

  public function create(CreateHopDongRequest $request) {
    $data = $request->only([
      'sohopdong', 'tenhopdong', 'giatri', 'tenkhachhang',
      'sodienthoai', 'email', 'diachi'
    ]);

    $data['nhanvien_id'] = getNhanVienID();

    $hopdong = $this->repository->create($data);
    return responseFormData('Tạo hợp đồng thành công');
  }
}
