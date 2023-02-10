<?php

namespace App\Http\Handlers;

use App\Http\Responses\Request;
use App\Http\Responses\ShowGenerationNumberResponse;

interface ShowGenerationNumberHandlerInterface
{
    public function handle(Request $request): ShowGenerationNumberResponse;
}