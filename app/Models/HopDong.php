<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NhanVien;

class HopDong extends Model
{
  protected $table = 'hopdong';

  protected $guarded = ['*'];

  public function nhanvien()
  {
  	return $this->belongsTo(NhanVien::class);
  }

  public function remove()
  {
    $this->deleted = 1;
    $this->save();
  }

  public function trangthaiduyet()
  {
  	$trangthai = 0;
  	switch ($this->trangthai) {
  		case 'Đã duyệt':
  			$trangthai = 1;
  			break;
  		case 'Chưa gửi':
  			$trangthai = 0;
  			break;
  		case 'Gửi duyệt':
  			$trangthai = 2;
  			break;
  		default:
  			$trangthai = 0;
  			break;
  	}
  	return $trangthai;
  }
}
