<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ThamSo extends Model
{
  protected $table = 'thamso';
  protected $fillable = ['id', 'mathamso', 'tenthamso', 'giatrithamso','mota'];
  
  public function User(){
      return $this->hasMany(User::class);
  }
 
}