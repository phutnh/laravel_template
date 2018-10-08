<?php

namespace App\Repositories\Repository;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\NhanVien;

class NhanVienRepository extends BaseRepository
{
  function model()
  {
  	return NhanVien::class;
  }
}