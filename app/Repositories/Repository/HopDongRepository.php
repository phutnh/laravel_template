<?php

namespace App\Repositories\Repository;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\HopDong;

class HopDongRepository extends BaseRepository
{
  function model()
  {
  	return HopDong::class;
  }
}