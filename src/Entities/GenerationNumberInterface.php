<?php

namespace App\Entities;

interface GenerationNumberInterface extends EntityInterface
{
    public function getGenerationId(): string;
}