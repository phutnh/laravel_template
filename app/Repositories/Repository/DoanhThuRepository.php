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

  public function datatables()
  {
  	$doanhthu = $this->query()->with(['nhanvien', 'nguoichot'])->select('doanhthu.*');
  	return $doanhthu->get();
  }
}