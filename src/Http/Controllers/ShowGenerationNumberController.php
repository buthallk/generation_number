<?php

namespace App\Http\Controllers;

use App\Http\Handlers\ShowGenerationNumberHandlerInterface;
use App\Http\Responses\Request;
use App\Http\Responses\Response;

class ShowGenerationNumberController implements ControllerInterface
{
    public function __construct(private readonly ShowGenerationNumberHandlerInterface $createGenerationNumberHandler)
    {

    }

    public function index(Request $request): Response
    {
        return $this->createGenerationNumberHandler->handle($request);
    }
}