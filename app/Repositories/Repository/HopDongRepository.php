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
    
    $hopdong->where('deleted', 0);
    // if (getQuyenNhanVien() == '1') {
    //   $hopdong->where('trangthai', '<>', 'Chưa gửi');
    //   $hopdong->orWhere('nhanvien_id', getNhanVienID());
    // }
    return $hopdong->get();
  }

  public function createHopDong($request)
  {
  	$data = $request->only([
      'sohopdong', 'tenhopdong', 'giatri', 'tenkhachhang',
      'sodienthoai', 'email', 'diachi'
    ]);

    $listFile = '';

    foreach ($request->dinhkem as $file) {
      $listFile .= uploadFileData($file, 'uploads/hopdong') . '|';
    }

    $data['nhanvien_id'] = getNhanVienID();
    $data['dinhkem'] = rtrim($listFile, '|');
    $data['trangthai'] = 'Chưa gửi';
    $data['created_at'] = new DateTime;

    $this->create($data);
  }

  public function updateHopDong($request)
  {
  	$data = $request->only([
      'tenhopdong', 'giatri', 'tenkhachhang',
      'sodienthoai', 'email', 'diachi'
    ]);

    $data['nhanvien_id'] = getNhanVienID();
    $data['updated_at'] = new DateTime;

    $this->update($data, $request->id);
  }
}