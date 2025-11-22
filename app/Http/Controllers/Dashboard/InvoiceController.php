<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Cart;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\InvoiceItem;
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
        $invoices = Invoice::whereHas('client.user',function($q) {
            $q->where('id',Auth::id());
        })->with('invoiceItems')->paginate(10);
        return view('dashboard.invoices.index', compact('invoices'));
    }

    /**
     * Search invoices by invoice number or client name.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // dd($query);
        $invoices = Invoice::whereHas('client.user', function($q) {
            $q->where('id', Auth::id());
        })
        ->where(function($q) use ($query) {
            $q->where('invoice_number', 'like', '%'.$query.'%')
            ->orWhereHas('client', function($q2) use ($query) {
                $q2->where('username', 'like', '%'.$query.'%');
            });
        })
        ->with('invoiceItems')
        ->paginate(10);
        if ($request->ajax()) {
            return response()->json([
                'table' => view('dashboard.invoices.data-invoice', compact('invoices'))->render(),
                'pagination' => view('dashboard.invoices.invoices-pagination', compact('invoices'))->render(),
            ]);
        }

        return view('dashboard.invoices.index', compact('invoices'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clients = Client::where('user_id',Auth::id())->get();
        $products = Product::get();

        if($request->ajax()) {
            return view('dashboard.invoices.data', compact('products'))->render();
        }
        return view('dashboard.invoices.create', compact('products','clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            "invoice_number" => "required|unique:invoices,invoice_number",
            "invoice_date" => "required|date|after_or_equal:today",
            "due_date" => "required|date|after_or_equal:invoice_date",
            'products_json' => 'required|json',
            'client_id' => 'required|exists:clients,id',
        ]);
        
        // dd( $request->all());
        $total_amount = 0;
        // dd(json_decode($request->products_json, true));
        foreach (json_decode($request->products_json, true) as $item) {
            $product = Product::findOrFail($item['product_id']);
            if ($item['quantity'] > $product->quantity) {
                return redirect()
                    ->back()
                    ->with('warning','they quantity for product not availd!');
            }
            $total_amount += $product->price * $item['quantity'];
        }

        $invoice = Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'client_id' => $request->client_id,
            'total_amount' => $total_amount,
        ]);

        foreach (json_decode($request->products_json, true) as $item) {
            $product = Product::findOrFail($item['product_id']);
            InvoiceItem::firstOrCreate([
                'invoice_id' => $invoice->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'description' => $item['description'] ?? $product->description,
                'unit_price' => $product->price,
            ]);
            $product->quantity -= $item['quantity'];
            $product->save();

        }
        
        return redirect()->route('dashboard.invoices.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::whereHas('client.user',function($q) {
            $q->where('id',Auth::id());
        })->with('invoiceItems')->findOrFail($id);

        return view('dashboard.invoices.details', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clients = Client::where('user_id',Auth::id())->get();
        $products = Product::get();
        $invoice = Invoice::whereHas('client.user',function($q) {
            $q->where('id',Auth::id());
        })->findOrFail($id);

        $invoiceItems = InvoiceItem::where('invoice_id',$invoice->id)->get();

        return view('dashboard.invoices.edit', compact('invoice', 'clients', 'products','invoiceItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "invoice_number" => "required|unique:invoices,invoice_number,".$id,
            "invoice_date" => "required|date|after_or_equal:today",
            "due_date" => "required|date|after_or_equal:invoice_date",
            'products_json' => 'required|json',
            'client_id' => 'required|exists:clients,id',
        ]);

        $total_amount = 0;
        foreach (json_decode($request->products_json, true) as $item) {
            $product = Product::findOrFail($item['product_id']);
            if ($item['quantity'] > $item['oldQuantity']) {
                return redirect()
                    ->back()
                    ->with('warning','they quantity for product not availd!');
            }
            $total_amount += $product->price * $item['quantity'];
        }

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
        foreach (json_decode( $request->products_json, true) as $item) {
            $product = Product::findOrFail($item['product_id']);
            InvoiceItem::firstOrCreate([
                'invoice_id' => $invoice->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'description' => $item['description'] ?? $product->description,
                'unit_price' => $product->price,
            ]);
            $product->quantity = abs($item['oldQuantity'] - $item['quantity']);

            $product->save();
        }

        return redirect()->route('dashboard.invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::whereHas('client.user',function($q) {
            $q->where('id',Auth::id());
        })->findOrFail($id);

        $items = $invoice->invoiceItems;

        foreach ($items as $item) {
            $product = Product::find($item->product_id);

            if ($product) {
                $product->quantity += $item->quantity;
                $product->save();
            }
        }

        $invoice->invoiceItems()->delete();
        $invoice->delete();
        return redirect()->route('dashboard.invoices.index');
    }


    /**
     * Generate PDF for the specified invoice.
     */
    public function generatePdf(Invoice $invoice)
    {
        // Ensure the authenticated user owns the invoice
        if ($invoice->client->user_id !== Auth::id()) {
            return redirect()->route('dashboard.invoices.index')->with('error', 'Unauthorized access to invoice PDF.');
        } 
        // Generate PDF logic here (using a PDF library like Dompdf or Snappy)
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('dashboard.invoices.pdf_detail', compact('invoice'));   
        return $pdf->download('invoice_'.$invoice->invoice_number.'.pdf');
    }
}
