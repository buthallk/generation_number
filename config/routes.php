<?php

use App\Http\Controllers\CreateGenerationNumberController;
use App\Http\Controllers\ShowGenerationNumberController;

return
    $routes = [
        'GET' => [
            '/api/v1/generationNumber/show' => ShowGenerationNumberController::class
        ],
        'POST' => [
            '/api/v1/generationNumber/generate' => CreateGenerationNumberController::class,
        ],
    ];