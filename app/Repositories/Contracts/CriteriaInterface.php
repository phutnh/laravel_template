<?php

namespace App\Repositories\Contracts;
use App\Repositories\Contracts\RepositoryInterface;

interface CriteriaInterface
{
  public function apply($model, RepositoryInterface $repository);
}
