<?php

namespace App\Repositories\Repository;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
  function model()
  {
  	return User::class;
  }
}