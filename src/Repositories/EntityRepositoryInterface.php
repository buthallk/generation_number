<?php

namespace App\Repositories;

use App\Entities\EntityInterface;

interface EntityRepositoryInterface
{
    public function findOneBy(array $where): ?EntityInterface;
}