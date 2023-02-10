<?php

namespace App\Commands;

use App\Drivers\ConnectionInterface;
use App\Entities\GenerationNumber;
use App\Entities\GenerationNumberInterface;
use App\Repositories\GenerationNumberRepositoryInterface;

class CreateGenerationNumberCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ConnectionInterface                 $connection,
        private readonly GenerationNumberRepositoryInterface $generationNumberRepository
    ){
    }

    /**
     * @return GenerationNumberInterface
     * @var EntityCommand $command
     */
    public function handle(EntityCommand $command): GenerationNumberInterface
    {
        /**
         * @var GenerationNumber $generationNumber
         */
        $generationNumber = $command->getEntity();

        try {
            $this->connection->beginTransaction();
            $stmt = $this->connection->prepare($this->getSQL());

            $stmt->execute(
                [
                    ':generation_id' => $generationNumber->getGenerationId(),
                ]
            );

            $id = $this->connection->lastInsertId();
            $this->connection->commit();
        }
        catch(\PDOException $e ) {
            $this->connection->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }

        return $this->generationNumberRepository->findOneBy(['id' => $id]);
    }

    public function getSQL(): string
    {
        return "INSERT INTO generation_number (generation_id) 
        VALUES (:generation_id)";
    }
}