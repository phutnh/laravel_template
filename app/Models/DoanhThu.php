<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NhanVien;
use App\Models\ChiTietDoanhThu;

class DoanhThu extends Model
{
  protected $table = 'doanhthu';
  
  public function nguoichot()
  {
  	return $this->belongsTo(NhanVien::class, 'nguoichot_id', 'id');
  }

  public function chitietdoanhthu()
  {
  	return $this->hasMany(ChiTietDoanhThu::class, 'doanhthu_id', 'id');
  }
}
