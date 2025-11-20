<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboradController extends Controller
{
    /**
     * Display a listing of the dashboard.
     */
    public function index()
    {
        $invoices = Invoice::with('invoiceItems')->cursor();

        $totalProducts = $invoices->map(fn($invoice) => $invoice->invoiceItems->pluck('product_id'))->unique()->count();

        $totalCustomers = $invoices->pluck('client')->unique()->count();

        $totalUsers = $invoices->pluck('client.user_id')->unique()->count();


        return view('dashboard.dashboard' , compact('invoices', 'totalProducts','totalProducts', 'totalCustomers', 'totalUsers'));
    }
}
