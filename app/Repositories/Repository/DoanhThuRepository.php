<?php

namespace App\Repositories\Repository;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\DoanhThu;
use App\Models\ChiTietDoanhThu;

class DoanhThuRepository extends BaseRepository
{
  function model()
  {
  	return DoanhThu::class;
  }

  public function danhThuDaChot($request)
  {
  	$doanhthu = $this->query()->with(['nguoichot'])->select('doanhthu.*');
  	return $doanhthu->get();
  }

  public function doanhThuThang($request)
  {
  	$chitietdoanhthu = ChiTietDoanhThu::groupBy('nhanvien_id', 'doanhthu_id');
  	$start_date = $request->start_date;
    if ($start_date) {
      $start_date = formatDateSqlData($start_date);
    }
    else {
      $start_date = getFristDayOfMonth($start_date);
    }

    $end_date = date("Y-m-t", strtotime($start_date));
    $chitietdoanhthu->with('nhanvien');
    $chitietdoanhthu->with('doanhthu');
    $chitietdoanhthu->whereDate('created_at', '>=', $start_date);
    $chitietdoanhthu->whereDate('created_at', '<=', $end_date);
    $chitietdoanhthu->selectRaw('nhanvien_id, doanhthu_id, sum(sotien) as sotiennv');

  	return $chitietdoanhthu->get();
  }
}