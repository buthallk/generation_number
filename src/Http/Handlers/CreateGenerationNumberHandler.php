<?php

namespace App\Http\Handlers;

use App\Commands\CreateGenerationNumberCommandHandler;
use App\Commands\EntityCommand;
use App\Entities\GenerationNumber;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessfulResponse;
use Psr\Log\LoggerInterface;

class CreateGenerationNumberHandler implements CreateGenerationNumberHandlerInterface
{
    public function __construct(
        private readonly CreateGenerationNumberCommandHandler $commandHandler,
        private readonly LoggerInterface $logger
    ){
    }

    public function handle(): SuccessfulResponse|ErrorResponse
    {
        try {
            $generationNumber = new GenerationNumber(uniqid());
            $generationNumber = $this->commandHandler->handle(new EntityCommand($generationNumber));
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            $this->logger->error($exception);
            return new ErrorResponse($message);
        }

        $data = [
            'id' => $generationNumber->getId(),
            'generationId' => $generationNumber->getGenerationId(),
        ];

        $this->logger->info('Created new GenerationNumber', $data);
        return new SuccessfulResponse($data);
    }
}