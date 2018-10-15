<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use App\Models\HopDong;
use DB;

class NhanVien extends Authenticatable
{
  use Notifiable;

  protected $table = 'nhanvien';
  
  protected $fillable = [
    'name', 'email', 'password',
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPassword($token));
  }

  public function hopdong()
  {
    return $this->hasMany(HopDong::class);
  }

  public function parent()
  {
    return $this->find($this->parent_id);
  }

  public function getAncestorsAttribute()
  {
    $ancestors = $this->ancestors();
    $data = [];

    foreach ($ancestors as $act) {
      $ancestor = $this->find($act->id);
      if ($ancestor)
        array_push($data, $ancestor);
    }

    return $data;
  }

  private function ancestors()
  {
    $query = 'SELECT T2.id,
      T2.tennhanvien
      FROM
        ( SELECT @r AS _id,
           (SELECT @r := parent_id
            FROM nhanvien
            WHERE id = _id) AS parent_id, @l := @l + 1 AS lvl
         FROM
           (SELECT @r := '.$this->id.', @l := 0) vars,
              nhanvien m
         WHERE @r <> 0) T1
      JOIN nhanvien T2 ON T1._id = T2.id
      ORDER BY T1.lvl ASC';
    $ancestors = collect(DB::select($query));
    $ancestors->splice(0,1);
    return $ancestors;
  }
}
