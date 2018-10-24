<?php

namespace App\Repositories\Repository;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\HopDong;
use DateTime;

class HopDongRepository extends BaseRepository
{
  function model()
  {
  	return HopDong::class;
  }

  public function datatables($request)
  {
    $hopdong = $this->query()->select('*');
    if (intval($request->notify_id) > 0)
      $hopdong->where('id', $request->notify_id);
    if (getQuyenNhanVien() != 1)
      $hopdong->where('nhanvien_id', getNhanVienID());
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    if ($start_date && $end_date) {
      $start_date = $start_date;
      $end_date = $end_date;
    }
    else {
      $start_date = getFristDayOfMonth();
      $end_date = getLastDayOfMonth();
    }

    $hopdong->whereDate('created_at', '>=', $start_date);
    $hopdong->whereDate('created_at', '<=', $end_date);
    $trangthai = $request->trangthai;
    if($trangthai != 'all')
      $hopdong->where('trangthai', $trangthai);

    $hopdong->where('deleted', 0);
    return $hopdong->get();
  }

  public function createHopDong($request)
  {
  	$data = $request->only([
      'sohopdong', 'tenhopdong', 'giatri', 'tenkhachhang', 'masothue',
      'sodienthoai', 'email', 'diachi', 'ngayhieuluc', 'ngayketthuc'
    ]);

    if($request->file('dinhkem'))
    {
      $listFile = '';

      foreach ($request->dinhkem as $file) {
        $listFile .= uploadFileData($file, 'uploads/hopdong') . '|';
      }
      $data['dinhkem'] = rtrim($listFile, '|');
    }
    
    $data['nhanvien_id'] = getNhanVienID();
    
    $data['trangthai'] = 'Chưa gửi';
    $data['created_at'] = new DateTime;
    $data['updated_at'] = new DateTime;
    $this->create($data);
  }

  public function updateHopDong($request)
  {
  	$data = $request->only([
      'tenhopdong', 'giatri', 'tenkhachhang', 'masothue',
      'sodienthoai', 'email', 'diachi', 'ngayhieuluc', 'ngayketthuc'
    ]);

    if($request->file('dinhkem'))
    {
      $listFile = '';

      foreach ($request->dinhkem as $file) {
        $listFile .= uploadFileData($file, 'uploads/hopdong') . '|';
      }
      
      $hopdong = $this->find($request->id);
      $data['dinhkem'] = $hopdong->dinhkem .'|'. rtrim($listFile, '|');
    }
    
    $data['nhanvien_id'] = getNhanVienID();
    $data['updated_at'] = new DateTime;
    $this->update($data, $request->id);
  }

  public function dataBieuDoHopDong($request)
  {
    $query = $this->query()
      ->selectRaw('count(hopdong.id) tonghopdong, date(ngayduyet) nd');

    if (!isAdminCP())
      $query->where('hopdong.nhanvien_id', getNhanVienID());
    $query->where('trangthai', 'Đã duyệt');
    $query->where('deleted', 0);
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    if ($start_date && $end_date) {
      $start_date = $start_date;
      $end_date = $end_date;
    }
    else {
      $start_date = getFristDayOfMonth($start_date);
      $end_date = getLastDayOfMonth($end_date);
    }

    $query->whereDate('ngayduyet', '>=', $start_date);
    $query->whereDate('ngayduyet', '<=', $end_date);
    $query->groupBy('nd');
    return $query->get();
  }
}