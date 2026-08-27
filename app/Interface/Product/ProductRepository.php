<?php

namespace App\Interface\Product;

use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductInterface
{
    public function getAllProducts()
    {
        return Product::all();
    }
    public function getAllPaginatedWithUser()
    {
        return Product::with('user')->paginate(10);
    }

    public function getFirstFromTrashBySlug(string $slug)
    {
        return Product::onlyTrashed()->where('slug', $slug)->first();
    }

    public function restoreProductBySlug(ProductRequest $request)
    {
        $product = $this->getFirstFromTrashBySlug($request->slug);
        if ($product) {
            $product->restore();
            return redirect()->route('dashboard.products.edit', ['product' => $product])->with('success', 'Product restored successfully. You can now update it.');
        }
        return null;
    }

    public function storeImage(UploadedFile $image)
    {
        if ($image) {
            return $image->store('images/products', 'public');
        }
        return null;
    }

    public function createProduct(ProductRequest $request)
    {
        return Product::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'image' => $this->storeImage($request->file('image')),
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);
    }

    public function findProductBySlug(string $slug)
    {
        return Product::where('slug', $slug)->firstOrFail();
    }

    public function removeImage(Product $product)
    {
        if (Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        return null;
    }

    public function updateProduct(ProductRequest $request, Product $product)
    {
        if ($request->hasFile('image')) {
            $this->removeImage($product);
            $imagePath = $this->storeImage($request->file('image'));
        } else {
            $imagePath = $product->image;
        }

        $product->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'image' => $imagePath,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);
    }

    public function deleteProduct(Product $product)
    {
        $this->removeImage($product);
        $product->delete();
    }
}
