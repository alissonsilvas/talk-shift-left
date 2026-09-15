<?php

use Invoice\Invoice;

class PaymentService
{
    public function process(
        string $description,
        int $amount,
        \DateTime $dueDate,
        string $paymentMethod
    ) {
        return new Invoice($description, $amount, $dueDate, $paymentMethod);
    }
}
