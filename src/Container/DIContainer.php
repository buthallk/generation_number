<?php

namespace App\Container;

use App\Exceptions\NotFoundException;
use App\Traits\HasInstance;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;

class DIContainer implements ContainerInterface
{
    use HasInstance;

    private function __construct(){}

    private array $resolvers = [];

    public function bind(string $id, string|object $class):self
    {
        $this->resolvers[$id] = $class;
        return $this;
    }

    public function get(string $id): object
    {
        if (array_key_exists($id, $this->resolvers)) {
            $typeToCreate = $this->resolvers[$id];

            if (is_object($typeToCreate)) {
                return $typeToCreate;
            }

            return $this->get($typeToCreate);
        }

        if (!class_exists($id)) {
            throw new NotFoundException("Cannot resolve type: $id");
        }


        $reflectionClass = new ReflectionClass($id);
        $constructor = $reflectionClass->getConstructor();

        if(!$constructor)
        {
            return new $id();
        }

        $parameters = [];

        foreach ($constructor->getParameters() as $parameter) {

            $parameterType = $parameter->getType()->getName();
            $parameters[] = $this->get($parameterType);
        }

        return new $id(...$parameters);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function has(string $id): bool
    {
        try {
            $this->get($id);
        } catch (NotFoundException $e) {
            return false;

        }
    }
}