<?php

namespace App\Http\Handlers;

use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessfulResponse;

interface CreateGenerationNumberHandlerInterface
{
    public function handle(): SuccessfulResponse|ErrorResponse;
}