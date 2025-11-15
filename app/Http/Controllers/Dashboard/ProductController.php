<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('user')->paginate(10);
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
    public function store(Request $request)
    {
        $product = Product::onlyTrashed()->where('slug', $request->slug)->first();
        if($product){
            $product->restore();
            return $this->update($request, $product->id);
        }

        $request->validate([
            'title'=> 'required|max:255',
            'slug'=> 'required|unique:products,slug',
            'image'=> 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
            'price'=> 'required|numeric|min:0',
        ]);



        $slug = \Str::slug($request->slug);

        $imagePath = null;
        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('images/products', 'public');
        } else {
            $imagePath = null;
        }   

        Product::create([
            'title' => $request->title,
            'slug' => $slug,
            'image' => $imagePath,
            'price' => $request->price,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('dashboard.products.details', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('dashboard.products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'=> 'required|max:255',
            'slug'=> "required|unique:products,slug,$id",
            'image'=> 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
            'price'=> 'required|numeric|min:0',
        ]);

        $slug = \Str::slug($request->slug);
        
        
        $product = Product::findOrFail($id);

        // Handle Image Upload
        $imagePath = $product->image; 
        if($request->hasFile('image')){
            if($product->image){
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('images/products', 'public');
        }

        $product->update([
            'title' => $request->title,
            'slug' => $slug,
            'image' => $imagePath,
            'price' => $request->price,
        ]);

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('dashboard.products.index');
    }
}
