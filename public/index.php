<?php

use App\Exceptions\HttpException;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\Request;

$container = require __DIR__ . '/autoload_runtime.php';
$routes = require __DIR__ . '/../config/routes.php';

$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input'),
);

try {
    $path = $request->path();
} catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

try {
    $method = $request->method();
} catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

if (!array_key_exists($method, $routes)) {
    (new ErrorResponse('Method not found'))->send();
    return;
}

if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse('Path not found'))->send();
    return;
}

$actionClassName = $routes[$method][$path];

try {
    $controller = $container->get($actionClassName);
    $response = $controller->index($request);

    $response->send();
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
}
