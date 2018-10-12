<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use App\Models\HopDong;

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

  public function ancestors()
  {
    $ancestors = $this->where('id', '=', $this->parent_id)->get();

    while ($ancestors->last() && $ancestors->last()->parent_id != null)
    {
        $parent = $this->where('id', '=', $ancestors->last()->parent_id)->get();
        $ancestors = $ancestors->merge($parent);
    }

    return $ancestors;
  }

  public function getAncestorsAttribute()
  {
      return $this->ancestors();
      // or like this, if you want it the other way around
      // return $this->ancestors()->reverse();
  }
}
