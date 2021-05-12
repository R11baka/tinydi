<?php

namespace App;

class Container
{
    private array $services = [];

    public function register($abstraction, $implementation = null)
    {
        if ($implementation === null) {
            $implementation = $abstraction;
        }
        $this->services[$abstraction] = $implementation;
    }

    private function registerIfNotExists($abstraction, $implementation = null)
    {
        if (array_key_exists($abstraction, $this->services) === false) {
            $this->register($abstraction, $implementation);
        }
    }

    public function make($itemName)
    {
        if (isset($this->services[$itemName])) {
            $className = $this->services[$itemName];
            return $this->resolveClass($className);
        }
        throw new \InvalidArgumentException("Item with $itemName not found");
    }

    private function resolveClass($className)
    {
        $reflectionClass = new \ReflectionClass($className);
        if ($reflectionClass->isInstantiable() === false) {
            throw new \InvalidArgumentException("Can't create $className.Not instantiable");
        }
        $constructorReflection = $reflectionClass->getConstructor();
        if ($constructorReflection === null) {
            return new $className;
        }
        if ($constructorReflection->getNumberOfParameters() === 0) {
            return new $className;
        }
        $params = $constructorReflection->getParameters();
        $constructorArgs = [];
        foreach ($params as $v) {
            $paramClass = $v->getClass();
            if ($paramClass !== null) {
                $this->registerIfNotExists($paramClass->name);
                $constructorArgs [] = $this->make($paramClass->name);
            } else {
                throw new \InvalidArgumentException("Can't resolve parameter for $className");
            }
        }
        return $reflectionClass->newInstanceArgs($constructorArgs);
    }
}
