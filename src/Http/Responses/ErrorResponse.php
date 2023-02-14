<?php

namespace App\Http\Responses;

class ErrorResponse extends Response
{
    protected const SUCCESS = false;

    public function __construct(private readonly string $reason = 'Something goes wrong')
    {

    }

    protected function payload(): array
    {
        return ['reason' => $this->reason];
    }
}