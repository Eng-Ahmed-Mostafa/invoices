<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceRequest;
use App\Interface\Client\ClientInterface;
use App\Interface\Invoice\InvoiceInterface;
use App\Interface\Product\ProductInterface;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    protected InvoiceInterface $invoiceRepository;

    protected ProductInterface $productRepository;

    protected ClientInterface $clientRepository;

    public function __construct(InvoiceInterface $invoiceRepository, ProductInterface $productRepository, ClientInterface $clientRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->productRepository = $productRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $invoices = $this->invoiceRepository->invoiceQuery($query)->paginate(10)->withQueryString();

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
        $clients = $this->clientRepository->getAllClients();
        $products = $this->productRepository->getAllProducts();

        if ($request->ajax()) {
            return view('dashboard.invoices.data', compact('products'))->render();
        }

        return view('dashboard.invoices.create', compact('products', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $request->validated();

        $items = json_decode($request->products_json, true);

        $this->invoiceRepository->createInvoice($request, $items);

        return redirect()->route('dashboard.invoices.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = $this->invoiceRepository->getInvoiceByIdWithItems($id);

        return view('dashboard.invoices.details', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clients = $this->clientRepository->getAllClients();
        $products = $this->productRepository->getAllProducts();
        $invoice = $this->invoiceRepository->getInvoiceByIdWithItems($id);

        return view('dashboard.invoices.edit', compact('invoice', 'clients', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, string $id)
    {
        $request->validated();
        $items = json_decode($request->products_json, true);

        $this->invoiceRepository->updateInvoice($request, $id, $items);

        return redirect()->route('dashboard.invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = $this->invoiceRepository->getInvoiceByIdWithItems($id);

        $items = $invoice->invoiceItems;
        
        $this->invoiceRepository->increaseProductQuantity($items);

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
