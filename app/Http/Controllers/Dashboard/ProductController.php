<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Interface\Product\ProductInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected ProductInterface $productInterface;

    public function __construct(ProductInterface $productInterface)
    {
        $this->productInterface = $productInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productInterface->getAllPaginatedWithUser();

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $restoredRedirect = $this->productInterface->restoreProductBySlug($request);
        if ($restoredRedirect) {
            return $restoredRedirect;
        }

        $request->validated();

        $this->productInterface->createProduct($request);

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('dashboard.products.details', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('dashboard.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $request->validated();

        $this->productInterface->updateProduct($request, $product);

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productInterface->deleteProduct($product);

        return redirect()->route('dashboard.products.index');
    }
}
