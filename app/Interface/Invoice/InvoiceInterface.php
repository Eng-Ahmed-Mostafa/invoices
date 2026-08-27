<?php

namespace App\Interface\Invoice;

use App\Http\Requests\Invoice\InvoiceRequest;

interface InvoiceInterface
{
    public function invoiceQuery($query);
    public function calcTotalAmount(array $items);
    public function createInvoice(InvoiceRequest $request, array $items);
    public function createInvoiceItems(int $invoice_id, array $items);
    public function getInvoiceByIdWithItems(int $id);
    public function updateInvoice(InvoiceRequest $request, int $id, array $items);
    public function increaseProductQuantity(array $items);
    public function decreaseProductQuantity(array $items);
}
