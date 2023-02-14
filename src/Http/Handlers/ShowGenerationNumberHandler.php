<?php

namespace App\Http\Handlers;

use App\Http\Responses\Request;
use App\Http\Responses\ShowGenerationNumberResponse;
use App\Repositories\GenerationNumberRepositoryInterface;

class ShowGenerationNumberHandler implements ShowGenerationNumberHandlerInterface
{
    public function __construct(private readonly GenerationNumberRepositoryInterface $generationNumberRepository)
    {
    }

    public function handle(Request $request): ShowGenerationNumberResponse
    {
        $id = $request->query('id');
        $errors = [];

        if(!$id) //TODO move to validation
        {
            $errors[] = 'The field «id» is required ';
        }

        if(!is_numeric($id)) //TODO move to validation
        {
            $errors[] = 'The field «id» must be a number';
        }

        if(!$generationNumber = $this->generationNumberRepository->findOneBy(['id' => $id])) //TODO move to validation
        {
            $errors[] = "Generation with id : $id not found";
        }

        return new ShowGenerationNumberResponse($generationNumber, $errors);
    }
}