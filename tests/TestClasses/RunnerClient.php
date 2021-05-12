<?php


namespace App\Tests\TestClasses;


class RunnerClient
{
    private RunnerInterface $runner;

    /**
     * RunnerClient constructor.
     */
    public function __construct(RunnerInterface $runner)
    {
        $this->runner = $runner;
    }
}
