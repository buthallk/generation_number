<?php

namespace App\Migrations;

use App\Drivers\ConnectionInterface;

abstract class AbstractMigration implements Migrations
{
    public function __construct(protected readonly ConnectionInterface $connection)
    {
    }
}