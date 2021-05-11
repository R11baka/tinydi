<?php

namespace App\Tests;

use App\Container;
use App\Tests\TestClasses\ClassWithArgumentsInConstructor;
use App\Tests\TestClasses\ClassWithUntypedArgs;
use App\Tests\TestClasses\FooController;
use App\Tests\TestClasses\FooControllerEmptyConstructor;
use App\Tests\TestClasses\Runner;
use App\Tests\TestClasses\TestRunner;
use InvalidArgumentException;
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
        $this->expectException(InvalidArgumentException::class);
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

    /**
     * @test
     */
    public function make_class_with_arguments()
    {
        $this->container->register(ClassWithArgumentsInConstructor::class);
        $controller = $this->container->make(ClassWithArgumentsInConstructor::class);
        $this->assertInstanceOf(ClassWithArgumentsInConstructor::class, $controller);
    }

    /**
     * @test
     */
    public function make_class_with_untyped_args()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->container->register(ClassWithUntypedArgs::class);
        $this->container->make(ClassWithUntypedArgs::class);
    }

    /**
     * @test
     */
    public function register_interface()
    {
        $this->container->register(Runner::class, TestRunner::class);
        $class = $this->container->make(Runner::class);
        $this->assertInstanceOf(TestRunner::class, $class);
        $this->assertInstanceOf(Runner::class, $class);
    }
}
