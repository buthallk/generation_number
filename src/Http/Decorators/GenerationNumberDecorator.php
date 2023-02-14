<?php

namespace App\Http\Decorators;

use App\Entities\GenerationNumber;

class GenerationNumberDecorator
{
    public int $id;

    public string|int $generationId;

    public function __construct(GenerationNumber $generationNumber)
    {
        $this->id  = $generationNumber->getId();
        $this->generationId = $generationNumber->getGenerationId();
    }
}