<?php

namespace App\Tests\TestClasses;


class ReportService
{
    private UserRepositoryInterface $userRepository;
    private ProductRepositoryInterface $productRepository;
    private EmailSenderInterface $emailSender;

    /**
     * ReportService constructor.
     */
    public function __construct(UserRepositoryInterface $userRepository, ProductRepositoryInterface $productRepository, EmailSenderInterface $emailSender)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->emailSender = $emailSender;
    }

    public function export(): string
    {
        return "run";
    }
}
