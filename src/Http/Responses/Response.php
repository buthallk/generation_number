<?php

namespace App\Http\Responses;

abstract class Response
{
    protected const SUCCESS = true;

    /**
     * @throws \JsonException
     */
    public function send(): void
    {
        echo $this->json();
    }

    /**
     * @throws \JsonException
     */
    public function json(): bool|string
    {
        $data = ['success' => static::SUCCESS] + $this->payload();
        header('Content-Type: application/json');

        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    abstract protected function payload(): array;
}