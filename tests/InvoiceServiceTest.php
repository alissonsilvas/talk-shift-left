<?php

use Invoice\Invoice;
use PHPUnit\Framework\TestCase;

final class InvoiceServiceTest extends TestCase
{
    public function testProcessCreatesAnInvoice(): void
    {
        $service = new InvoiceService();
        $dueDate = new DateTimeImmutable('2026-10-15');

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
        $dueDate = new DateTimeImmutable('2026-10-15');

        $invoice = $service->process(
            'Palestra Shift Left',
            1500,
            $dueDate,
            'pix'
        );

        self::assertSame('Palestra Shift Left', $invoice->getDescription());
        self::assertSame(1500, $invoice->getAmountInCents());
        self::assertSame($dueDate, $invoice->getDueDate());
        self::assertSame('pix', $invoice->getPaymentMethod());
        self::assertSame('pending', $invoice->getStatus());
    }

    public function testItRejectsAnEmptyDescription(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new InvoiceService()->process(
            '',
            1500,
            new DateTimeImmutable('2026-10-15'),
            'pix'
        );
    }

    public function testItRejectsAnInvalidAmount(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new InvoiceService()->process(
            'Palestra Shift Left',
            0,
            new DateTimeImmutable('2026-10-15'),
            'pix'
        );
    }

    public function testSettersUpdateInvoiceData(): void
    {
        $invoice = new InvoiceService()->process(
            'Palestra Shift Left',
            1500,
            new DateTimeImmutable('2026-10-15'),
            'pix'
        );
        $newDueDate = new DateTimeImmutable('2026-11-20');

        $invoice->setDescription('Workshop Shift Left');
        $invoice->setAmountInCents(2500);
        $invoice->setDueDate($newDueDate);
        $invoice->setPaymentMethod('credit-card');

        self::assertSame('Workshop Shift Left', $invoice->getDescription());
        self::assertSame(2500, $invoice->getAmountInCents());
        self::assertSame($newDueDate, $invoice->getDueDate());
        self::assertSame('credit-card', $invoice->getPaymentMethod());
    }

    public function testSettersRejectInvalidValues(): void
    {
        $invoice = new InvoiceService()->process(
            'Palestra Shift Left',
            1500,
            new DateTimeImmutable('2026-10-15'),
            'pix'
        );

        $this->expectException(InvalidArgumentException::class);

        $invoice->setAmountInCents(0);
    }
}
