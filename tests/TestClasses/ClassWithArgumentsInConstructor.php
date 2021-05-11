<?php


namespace App\Tests\TestClasses;


class ClassWithArgumentsInConstructor
{
    private FooController $controller;

    /**
     * ClassWithArgumentsInConstructor constructor.
     */
    public function __construct(FooController $controller)
    {
        $this->controller = $controller;
    }
}
