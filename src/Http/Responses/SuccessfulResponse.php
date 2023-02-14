<?php

namespace App\Http\Responses;

class SuccessfulResponse extends Response
{
    public function __construct(private readonly array $data = [])
    {
    }

    protected function payload(): array
    {
        return ['data' => $this->data];
    }
}