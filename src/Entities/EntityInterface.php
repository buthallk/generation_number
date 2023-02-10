<?php

namespace App\Entities;

interface EntityInterface
{
    public function getId(): ?int;

    public static function getTableName(): string;
}