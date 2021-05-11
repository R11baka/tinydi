<?php

namespace App;

class Container
{
    private array $services = [];

    public function register($itemName)
    {
        $this->services[$itemName] = $itemName;
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
        throw  new \InvalidArgumentException("Can't create $className");
    }
}
