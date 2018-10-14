<?php

namespace App\Repositories\Repository;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\DoanhThu;

class DoanhThuRepository extends BaseRepository
{
  function model()
  {
  	return DoanhThu::class;
  }

  public function datatables($request)
  {
  	$doanhthu = $this->query()->with(['nguoichot'])->select('doanhthu.*');
  	return $doanhthu->get();
  }
}