<?php

namespace App\Repositories;

use App\Entities\EntityInterface;
use App\Entities\GenerationNumber;

class GenerationNumberRepository extends EntityRepository implements GenerationNumberRepositoryInterface
{
    protected function getEntityType(): string
    {
       return GenerationNumber::class;
    }

    protected function getEntity(object $obj = null): ?EntityInterface //TODO move to data mapper
    {
        $generationNumber = null;

        if($obj)
        {
            $generationNumber = new GenerationNumber(generationId : $obj->generation_id,);
            $generationNumber->setId($obj->id);
        }

        return $generationNumber;
    }
}