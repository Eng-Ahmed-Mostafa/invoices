<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Cart;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::whereHas('client.user', function ($q) {
            $q->where('id', Auth::id());
        })->with('products')->paginate(10);

        return view('dashboard.carts.index', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::whereHas('user', function ($q) {
            $q->where('id', Auth::id());
        })->get();
        $products = Product::all();

        return view('dashboard.carts.create', compact('clients', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        if (Cart::where('client_id', $request->client_id)->exists()) {
            $this->addProduct($request, Cart::where('client_id', $request->client_id)->first()->id);

            return redirect()->route('dashboard.carts.index');
        }

        $cart = Cart::create([
            'client_id' => $request->client_id,
        ]);

        $cart->products()->attach($request->product, ['quantity' => $request->quantity]);

        return redirect()->route('dashboard.carts.index');
    }

    /**
     * Add Product to Cart
     */
    public function addProduct(Request $request, string $id)
    {
        $request->validate([
            'product' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $cart = Cart::whereHas('client.user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);

        $existing = $cart->products()->where('product_id', $request->product)->first();

        if ($existing) {
            $cart->products()->updateExistingPivot(
                $request->product,
                ['quantity' => $existing->pivot->quantity + $request->quantity]
            );
        } else {
            $cart->products()->attach($request->product, [
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('dashboard.carts.show', $id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cart = Cart::whereHas('client.user', function ($q) {
            $q->where('id', Auth::id());
        })->with('products')->findOrFail($id);

        return view('dashboard.carts.details', compact('cart'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clients = Client::whereHas('user', function ($q) {
            $q->where('id', Auth::id());
        })->get();
        $products = Product::all();
        $cart = Cart::whereHas('client.user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);

        return view('dashboard.carts.edit', compact('cart', 'clients', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $cart = Cart::whereHas('client.user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);
        $cart->update([
            'client_id' => $request->client_id,
        ]);
        $cart->products()->sync([
            $request->product => ['quantity' => $request->quantity],
        ]);
        return redirect()->route('dashboard.carts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Cart::whereHas('client.user', function ($q) {
            $q->where('id', Auth::id());
        })->findOrFail($id);
        $product->products()->detach();
        $product->delete();

        return redirect()->route('dashboard.carts.index');
    }
}
