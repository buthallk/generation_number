<?php

use App\Container\DIContainer;
use App\Drivers\ConnectionInterface;
use App\Drivers\PdoConnectionDriver;
use App\Http\Handlers\CreateGenerationNumberHandler;
use App\Http\Handlers\CreateGenerationNumberHandlerInterface;
use App\Http\Handlers\ShowGenerationNumberHandler;
use App\Http\Handlers\ShowGenerationNumberHandlerInterface;
use App\Repositories\GenerationNumberRepository;
use App\Repositories\GenerationNumberRepositoryInterface;
use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

require_once __DIR__ . '/../vendor/autoload.php';
Dotenv::createImmutable(__DIR__ . '/../')->safeLoad();

$container = DIContainer::getInstance();

$container->bind(
    ConnectionInterface::class,
    PdoConnectionDriver::getInstance($_ENV['DATABASE_DSN'], $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD'])
);

$container->bind(
    CreateGenerationNumberHandlerInterface::class,
    CreateGenerationNumberHandler::class
);

$container->bind(
    ShowGenerationNumberHandlerInterface::class,
    ShowGenerationNumberHandler::class
);

$container->bind(
    GenerationNumberRepositoryInterface::class,
    GenerationNumberRepository::class
);

$logger = new Logger('generation_number_logger');

$isNeedLogToFile = (bool)$_SERVER['LOG_TO_FILES'];
$isNeedLogToConsole = (bool)$_SERVER['LOG_TO_CONSOLE'];

if($isNeedLogToFile)
{
    $logger
        ->pushHandler(new StreamHandler(
            __DIR__ . '/../.logs/generation_number_logger.log'
        ))
        ->pushHandler(new StreamHandler(
            __DIR__ . '/../.logs/generation_number_logger.error.log',
            level: Logger::ERROR,
            bubble: false,
        ));
}

if($isNeedLogToConsole)
{
    $logger->pushHandler(new StreamHandler("php://stdout"));
}

$container->bind(
    LoggerInterface::class,
    (new Logger('generation_number_logger'))
        ->pushHandler(
            new StreamHandler(
                __DIR__ . '/../.logs/generation_number_logger.log'
            )
        )
        ->pushHandler(
            new StreamHandler(
                __DIR__ . '/../.logs/generation_number_logger.error.log',
                level: Logger::ERROR,
                bubble: false,
            )
        )
        ->pushHandler(new StreamHandler("php://stdout"))
);


return $container;
