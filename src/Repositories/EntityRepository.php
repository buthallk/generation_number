<?php

namespace App\Repositories;

use App\Drivers\ConnectionInterface;
use App\Entities\EntityInterface;
use PDO;
use ReflectionClass;

abstract class EntityRepository implements EntityRepositoryInterface
{
    public function __construct(protected ConnectionInterface $connection)
    {

    }

    abstract protected function getEntityType(): string;

    abstract protected function getEntity(object $obj = null): ?EntityInterface;

    /**
     * @throws \Exception
     */
    public function findOneBy(array $where): ?EntityInterface
    {
        /** @var EntityInterface $entity */
        $reflection = new ReflectionClass($this->getEntityType());
        $table = $reflection->getMethod('getTableName')->invoke(null);

        $executeParams = [];
        $strWhere = '';

        foreach ($where as $key => $val)
        {
            $executeParams[":$key"] = $val;
            $strWhere .= "$key = :$key";
        }

        $statement = $this->connection->prepare(
            "SELECT * FROM $table WHERE $strWhere"
        );

        $statement->execute($executeParams);
        $result = $statement->fetch(PDO::FETCH_OBJ);
        $obj = $result ? : null;

        return $this->getEntity($obj); //TODO move to data mapper
    }
}