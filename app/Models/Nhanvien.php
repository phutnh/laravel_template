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
    'tennhanvien', 'email', 'password',
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPassword($token));
  }

  public function hopDong()
  {
    $this->hasMany(Hopdong::class);
  }
}
