<?php

namespace App\Tests;

use App\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    /**
     * @test
     */
    public function register_simple_class()
    {
        $this->container->register(FooController::class);
        $controller = $this->container->make(FooController::class);
        $this->assertInstanceOf(FooController::class, $controller);
    }

    /**
     * @test
     */
    public function make_not_exists_class()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->container->make(FooController::class);
    }

    /**
     * @test
     */
    public function make_class_with_zero_arguments()
    {
        $this->container->register(FooControllerEmptyConstructor::class);
        $controller = $this->container->make(FooControllerEmptyConstructor::class);
        $this->assertInstanceOf(FooControllerEmptyConstructor::class, $controller);
    }
}
