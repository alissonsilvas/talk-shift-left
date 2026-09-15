<?php

use Invoice\Invoice;

class InvoiceService
{
    public function process(
        string $description,
        int $amountInCents,
        \DateTimeImmutable $dueDate,
        string $paymentMethod
    ): Invoice {
        return new Invoice($description, $amountInCents, $dueDate, $paymentMethod);
    }
}
