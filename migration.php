<?php

use App\Migrations\Migration_version_1;

$container = require __DIR__ . '/public/autoload_runtime.php';

$migration = $container->get(Migration_version_1::class);//TODO add versions from databases
$migration->execute();