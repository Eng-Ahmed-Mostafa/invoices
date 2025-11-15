<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::whereHas('cart.client.user', function ($q) {
            $q->where('id', Auth::id());
        })->with('cart.client')->paginate(10);
        return view('dashboard.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carts = Cart::whereHas('client.user', function ($q) {
            $q->where('id', Auth::id());
        })->get();
        return view('dashboard.invoices.create', compact('carts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "invoice_number" => "required|unique:invoices,invoice_number",
            "due_time" => "nullable|numeric|min:1",
            "cart_id" => "required|exists:carts,id",
        ]);

        $invoiceModel = new Invoice();
        $invoiceDate = Date::now();
        $due_date = $invoiceModel->dueDate($invoiceDate, $request->due_time);
        $total_amount = $invoiceModel->calcTotalAmount(Cart::findOrFail($request->cart_id)->products);
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $invoiceDate,
            'due_date' => $due_date,
            'cart_id' => $request->cart_id,
            'total_amount' => $total_amount,
        ]);


        
        return redirect()->route('dashboard.invoices.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::whereHas('cart.client.user', function ($q) {
            $q->where('id', Auth::id());
        })->with('cart.products')->findOrFail($id);
        return view('dashboard.invoices.details', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $carts = Cart::whereHas('client.user', function ($q) {
            $q->where('id', Auth::id());
        })->get();
        $invoice = Invoice::whereHas('cart.client.user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);
        return view('dashboard.invoices.edit', compact('invoice', 'carts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "invoice_number" => "required|unique:invoices,invoice_number,".$id,
            "due_time" => "nullable|numeric|min:1",
            "cart_id" => "required|exists:carts,id",
        ]);

        $invoiceModel = new Invoice();
        $invoice = Invoice::whereHas('cart.client.user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);
        $due_date = $invoiceModel->dueDate($invoice->invoice_date, $request->due_time);
        
        $total_amount = $invoiceModel->calcTotalAmount(Cart::findOrFail($request->cart_id)->products);
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $invoice->invoice_date,
            'due_date' => $due_date,
            'cart_id' => $request->cart_id,
            'total_amount' => $total_amount,
        ]);

        return redirect()->route('dashboard.invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::whereHas('cart.client.user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);
        $invoice->delete();
        return redirect()->route('dashboard.invoices.index');
    }
}
