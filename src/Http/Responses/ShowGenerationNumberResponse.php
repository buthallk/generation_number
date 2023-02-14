<?php

namespace App\Http\Responses;

use App\Entities\GenerationNumber;
use App\Http\Decorators\GenerationNumberDecorator;

class ShowGenerationNumberResponse extends Response
{
    public function __construct(
        private readonly ?GenerationNumber $generationNumber = null,
        private readonly array $errors = []
    ){
    }

    protected function payload(): array
    {
        return [
            'generationNumber' => $this->generationNumber ?
                new GenerationNumberDecorator($this->generationNumber) : null,
            'errors' => $this->errors
        ];
    }
}