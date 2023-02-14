<?php

namespace App\Migrations;

class Migration_version_1 extends AbstractMigration
{
    public function execute(): void
    {
        $this->connection->executeQuery('CREATE DATABASE IF NOT EXISTS generation_number');

        $this->connection->executeQuery(
            "create table generation_number
                        (
                            id integer primary key auto_increment,
                            generation_id varchar(256)
                        );            
                        create index generation_id on generation_number (generation_id);
                     "
        );
    }
}