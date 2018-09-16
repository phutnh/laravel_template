<?php

namespace App\Repositories\Repository;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Blog;

class BlogRepository extends BaseRepository
{
  function model()
  {
  	return Blog::class;
  }
}