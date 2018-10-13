<?php

namespace App\Repositories\Repository;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\HoaHong;

class HoaHongRepository extends BaseRepository
{
  function model()
  {
  	return HoaHong::class;
  }

  public function save()
  {
  	
  }
}