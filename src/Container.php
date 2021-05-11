<?php

namespace App;

class Container
{
    private array $services = [];

    public function register($className)
    {
        $this->services[$className] = $className;
    }

    public function make($className)
    {
        if (isset($this->services[$className])) {
            return new $className();
        }
        throw new \InvalidArgumentException("$className not found");
    }

}
