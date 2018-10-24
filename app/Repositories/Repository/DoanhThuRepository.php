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
    $start_date = intval($request->start_date);
  	$doanhthu = $this->query()->with(['nguoichot'])
      ->where('thangchot', 'like', "$start_date%")
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
        'nhanvien.manhanvien', 'nhanvien.sodidong', 'nhanvien.taikhoan', 'nhanvien.tennganhang', 'nhanvien.chinhanh', 'nhanvien.sodidong'
      ]);
  	return $data;
  }

  public function dataBieuDoDoanhThu($request)
  {
    $query = $this->query()
      ->select('doanhthu.thangchot')
      ->groupBy('doanhthu.thangchot')
      ->selectRaw('sum(chitietdoanhthu.sotien) as sotien')
      ->orderBy('doanhthu.thangchot')
      ->join('chitietdoanhthu', 'doanhthu.id', '=', 'chitietdoanhthu.doanhthu_id');
    if (!isAdminCP())
      $query->where('chitietdoanhthu.nhanvien_id', getNhanVienID());

    if ($request->start_year)
    {
      $start_year = intval($request->start_year);
      $query->where('doanhthu.thangchot', 'like', "$start_year%");
    } else {
      $start_year = date('Y');
      $query->where('doanhthu.thangchot', 'like', "$start_year%");
    }
    return $query->get();
  }
}