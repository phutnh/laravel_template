<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NhanVien;

class DoanhThu extends Model
{
  protected $table = 'doanhthu';

  public function nhanvien()
  {
  	return $this->belongsTo(NhanVien::class);
  }

  public function nguoichot()
  {
  	return $this->belongsTo(NhanVien::class, 'nguoichot_id', 'id');
  }
}
