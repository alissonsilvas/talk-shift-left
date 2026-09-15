<?php

use Invoice\Invoice;
use PHPUnit\Framework\TestCase;

final class InvoiceServiceTest extends TestCase
{
    public function testProcessCreatesAnInvoice(): void
    {
        $service = new InvoiceService();
        $dueDate = new DateTime('2026-10-15');

        $invoice = $service->process(
            'Palestra Shift Left',
            1500,
            $dueDate,
            'pix'
        );

        self::assertInstanceOf(Invoice::class, $invoice);
    }

    public function testProcessPreservesInvoiceData(): void
    {
        $service = new InvoiceService();
        $dueDate = new DateTime('2026-10-15');

        $invoice = $service->process(
            'Palestra Shift Left',
            1500,
            $dueDate,
            'pix'
        );

        self::assertSame('Palestra Shift Left', $invoice->getDescription());
        self::assertSame(1500, $invoice->getAmount());
        self::assertSame($dueDate, $invoice->getDueDate());
        self::assertSame('pix', $invoice->getPaymentMethod());
        self::assertSame('pending', $invoice->getStatus());
    }
}
