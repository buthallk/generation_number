<?php

namespace App\Commands;

use App\Entities\EntityInterface;

class EntityCommand
{
    public function __construct(private readonly EntityInterface $entity)
    {

    }

    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }
}