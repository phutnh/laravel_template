<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NhanVien;

class HoaHong extends Model
{
  protected $table = 'hoahong';

  public function nhanvien()
  {
  	return $this->belongsTo(NhanVien::class);
  }
}
