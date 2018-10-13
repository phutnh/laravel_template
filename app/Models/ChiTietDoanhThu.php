<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NhanVien;
use App\Models\DoanhThu;

class ChiTietDoanhThu extends Model
{
  protected $table = 'chitietdoanhthu';

   protected $fillable = [
    'nhanvien_id', 'doanhthu_id', 'sotien', 'created_at', 'updated_at'
  ];

  public function nhanvien()
  {
  	return $this->belongsTo(NhanVien::class);
  }

  public function doanhthu()
  {
  	return $this->belongsTo(DoanhThu::class);
  }
}
