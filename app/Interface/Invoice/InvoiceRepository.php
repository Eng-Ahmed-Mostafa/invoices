<?php

namespace App\Interface\Invoice;

use App\Http\Requests\Invoice\InvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class InvoiceRepository implements InvoiceInterface
{

    public function invoiceQuery($query)
    {
        return Invoice::query()->whereRelation('client.user', 'id', Auth::id())
            ->when($query, function ($q) use ($query) {
                $q->where(function ($search) use ($query) {
                    $search->where('invoice_number', 'like', '%' . $query . '%')
                        ->orWhereRelation('client', 'username', 'like', "%{$query}%");
                });
            })
            ->with(['client', 'invoiceItems']);
    }

    public function calcTotalAmount(array $items)
    {
        $total_amount = 0;
        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);

            if ($item['quantity'] > $product->quantity) {
                return redirect()->back()->with('warning', 'The quantity for product not available!');
            }

            $total_amount += $product->price * $item['quantity'];
        }
        return $total_amount;
    }

    public function createInvoice(InvoiceRequest $request, array $items)
    {
        $total_amount = $this->calcTotalAmount($items);

        $invoice = Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'client_id' => $request->client_id,
            'total_amount' => $total_amount,
        ]);

        $this->createInvoiceItems($invoice->id, $items);
    }

    public function createInvoiceItems(int $invoice_id, array $items)
    {
        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);
            InvoiceItem::firstOrCreate([
                'invoice_id' => $invoice_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'description' => $item['description'] ?? $product->description,
                'unit_price' => $product->price,
            ]);

            $product->quantity -= $item['quantity'];
            $product->save();
        }
    }

    public function getInvoiceByIdWithItems(int $id)
    {
        return Invoice::whereRelation('client.user', 'id', Auth::id())->with('invoiceItems')->findOrFail($id);
    }

    public function updateInvoice(InvoiceRequest $request, int $id, array $items)
    {
        $total_amount = $this->calcTotalAmount($items);

        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'client_id' => $request->client_id,
            'total_amount' => $total_amount,
        ]);

        // Update Invoice Items
        $invoice->invoiceItems()->delete();
        $this->createInvoiceItems($invoice->id, $items);
    }

    public function increaseProductQuantity(array $items)
    {
        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $product->quantity += $item['quantity'];
            $product->save();
        }
    }

    public function decreaseProductQuantity(array $items)
    {
        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $product->quantity -= $item['quantity'];
            $product->save();
        }
    }
}
