<?php

namespace App\Entities;

use App\Traits\HasId;

class GenerationNumber implements GenerationNumberInterface
{
    use HasId;

    public const TABLE_NAME = 'generation_number';

    public function __construct(private readonly string $generationId)
    {
    }

    public function getGenerationId(): string
    {
        return $this->generationId;
    }

    public static function getTableName(): string
    {
        return static::TABLE_NAME;
    }
}