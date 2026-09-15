<?php

namespace Invoice;

class Invoice
{
    private string $description;
    private int $amount;
    private \DateTime $dueDate;
    private string $paymentMethod;
    private string $status = 'pending';

    public function __construct(
        string $description,
        int $amount,
        \DateTime $dueDate,
        string $paymentMethod
    ) {
        $this->description = $description;
        $this->amount = $amount;
        $this->dueDate = $dueDate;
        $this->paymentMethod = $paymentMethod;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getDueDate(): \DateTime
    {
        return $this->dueDate;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
