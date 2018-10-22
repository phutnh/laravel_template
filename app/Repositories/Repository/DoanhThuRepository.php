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

  public function doanhThuDaChot($request)
  {
    $start_date = $request->start_date;
  	$doanhthu = $this->query()->with(['nguoichot'])
      ->where('thangchot', $start_date)
      ->select('doanhthu.*');
  	return $doanhthu->get();
  }

  public function doanhThuThang($request)
  {
    $start_date = $request->start_date;
    $data = $this->query()
      ->join('chitietdoanhthu', 'doanhthu.id', '=', 'chitietdoanhthu.doanhthu_id')
      ->join('nhanvien', 'chitietdoanhthu.nhanvien_id', '=', 'nhanvien.id')
      ->where('thangchot', $start_date)
      ->select([
        'doanhthu.thangchot', 'nhanvien.tennhanvien', 'chitietdoanhthu.sotien',
        'nhanvien.manhanvien', 'nhanvien.sodidong'
      ]);
  	return $data;
  }
}