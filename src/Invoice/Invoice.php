<?php

namespace Invoice;

use InvalidArgumentException;

final class Invoice
{
    private string $description;
    private int $amountInCents;
    private \DateTimeImmutable $dueDate;
    private string $paymentMethod;
    private string $status = 'pending';

    public function __construct(
        string $description,
        int $amountInCents,
        \DateTimeImmutable $dueDate,
        string $paymentMethod
    ) {
        $this->setDescription($description);
        $this->setAmountInCents($amountInCents);
        $this->setDueDate($dueDate);
        $this->setPaymentMethod($paymentMethod);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAmountInCents(): int
    {
        return $this->amountInCents;
    }

    public function getDueDate(): \DateTimeImmutable
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

    public function setDescription(string $description): void
    {
        $description = trim($description);

        if ($description === '') {
            throw new InvalidArgumentException('Invoice description cannot be empty.');
        }

        $this->description = $description;
    }

    public function setAmountInCents(int $amountInCents): void
    {
        if ($amountInCents <= 0) {
            throw new InvalidArgumentException('Invoice amount must be greater than zero.');
        }

        $this->amountInCents = $amountInCents;
    }

    public function setDueDate(\DateTimeImmutable $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    public function setPaymentMethod(string $paymentMethod): void
    {
        $paymentMethod = trim($paymentMethod);

        if ($paymentMethod === '') {
            throw new InvalidArgumentException('Invoice payment method cannot be empty.');
        }

        $this->paymentMethod = $paymentMethod;
    }

}
