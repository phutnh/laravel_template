<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NhanVien;

class HopDong extends Model
{
  protected $table = 'hopdong';

  public function nhanVien($value='')
  {
  	$this->belongsTo(Nhanvien::class);
  }
}
