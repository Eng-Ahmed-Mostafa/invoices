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
        $invoices = Invoice::whereHas('cart.client.user', function ($q) {
            $q->where('id', Auth::id());
        })->with('cart.client')->cursor();

        $totalProducts = $invoices->map(function($invoice) {
            return $invoice->cart->products->count() ?? 0;
        })->sum();

        $totalCustomers = $invoices->pluck('cart.client_id')->unique()->count();

        $totalUsers = $invoices->pluck('cart.client.user_id')->unique()->count();


        return view('dashboard.dashboard' , compact('invoices', 'totalProducts', 'totalCustomers', 'totalUsers'));
    }
}
