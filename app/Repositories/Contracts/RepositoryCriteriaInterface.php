<?php

namespace App\Repositories\Contracts;
use Illuminate\Support\Collection;

interface RepositoryCriteriaInterface
{
    public function pushCriteria($criteria);

    public function popCriteria($criteria);

    public function getCriteria();

    public function getByCriteria(CriteriaInterface $criteria);

    public function skipCriteria($status = true);

    public function resetCriteria();
}
