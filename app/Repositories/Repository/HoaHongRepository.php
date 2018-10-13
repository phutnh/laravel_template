<?php

namespace App\Repositories\Repository;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\HoaHong;

class HoaHongRepository extends BaseRepository
{
  function model()
  {
  	return HoaHong::class;
  }

  public function save($data)
  {
  	$this->create($data);
  }

  public function datatables()
  {
  	$doanhthu = $this->query()
  	->with(['nhanvien', 'hopdong'])
  	->where('trangthai', 0)
  	->select('hoahong.*');
  	return $doanhthu->get();
  }
}