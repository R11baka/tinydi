<?php

namespace App\Tests;

use App\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    /**
     * @test
     */
    public function register_simple_class()
    {
        $container = new Container();
        $container->register(FooController::class);
        $controller = $container->make(FooController::class);
        $this->assertInstanceOf(FooController::class, $controller);
    }

    /**
     * @test
     */
    public function make_not_exists_class()
    {
        $this->expectException(\InvalidArgumentException::class);
        $container = new Container();
        $container->make(FooController::class);
    }
}
