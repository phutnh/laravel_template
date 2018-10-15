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

  public function datatables($request)
  {
  	$hoahong = $this->query()
  	->with(['nhanvien', 'hopdong'])
  	->where('trangthai', 0)
  	;
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    if ($start_date && $end_date) {
      $start_date = formatDateSqlData($start_date);
      $end_date = formatDateSqlData($end_date);
    }
    else {
      $start_date = getFristDayOfMonth($start_date);
      $end_date = getLastDayOfMonth($end_date);
    }

    $hoahong->whereDate('created_at', '>=', $start_date);
    $hoahong->whereDate('created_at', '<=', $end_date);
    $hoahong->select('hoahong.*');
  	return $hoahong->get();
  }
}