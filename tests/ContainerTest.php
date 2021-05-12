<?php

namespace App\Tests;

use App\Container;
use App\Tests\TestClasses\ClassWithArgumentsInConstructor;
use App\Tests\TestClasses\ClassWithUntypedArgs;
use App\Tests\TestClasses\EmailSender;
use App\Tests\TestClasses\EmailSenderInterface;
use App\Tests\TestClasses\FooController;
use App\Tests\TestClasses\FooControllerEmptyConstructor;
use App\Tests\TestClasses\ProductRepository;
use App\Tests\TestClasses\ProductRepositoryInterface;
use App\Tests\TestClasses\ReportService;
use App\Tests\TestClasses\RunnerInterface;
use App\Tests\TestClasses\RunnerClient;
use App\Tests\TestClasses\TestRunnerInterface;
use App\Tests\TestClasses\UserRepository;
use App\Tests\TestClasses\UserRepositoryInterface;
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
        $this->container->register(RunnerInterface::class, TestRunnerInterface::class);
        $class = $this->container->make(RunnerInterface::class);
        $this->assertInstanceOf(TestRunnerInterface::class, $class);
        $this->assertInstanceOf(RunnerInterface::class, $class);
    }

    /**
     * @test
     */
    public function interface_resolve()
    {
        $this->container->register(RunnerClient::class);
        $this->container->register(RunnerInterface::class, TestRunnerInterface::class);
        $class = $this->container->make(RunnerClient::class);
        $this->assertInstanceOf(RunnerClient::class, $class);
    }

    /**
     * @test
     */
    public function test_report_service()
    {
        $this->container->register(ReportService::class);
        $this->container->register(UserRepositoryInterface::class, UserRepository::class);
        $this->container->register(ProductRepositoryInterface::class, ProductRepository::class);
        $this->container->register(EmailSenderInterface::class, EmailSender::class);
        $class = $this->container->make(ReportService::class);
        $this->assertInstanceOf(ReportService::class, $class);
    }
}
