<?php

namespace App\Http\Controllers;

use App\Http\Handlers\CreateGenerationNumberHandlerInterface;
use App\Http\Responses\Response;

class CreateGenerationNumberController implements ControllerInterface
{
    public function __construct(private readonly CreateGenerationNumberHandlerInterface $createGenerationNumberHandler)
    {

    }
    
    public function index(): Response
    {
        return $this->createGenerationNumberHandler->handle();
    }
}