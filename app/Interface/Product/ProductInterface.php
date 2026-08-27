<?php

namespace App\Interface\Product;

use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Http\UploadedFile;

interface ProductInterface
{
    public function getAllProducts();
    public function getAllPaginatedWithUser();
    public function getFirstFromTrashBySlug(string $slug);
    public function restoreProductBySlug(ProductRequest $request);
    public function storeImage(UploadedFile $image);
    public function createProduct(ProductRequest $request);
    public function findProductBySlug(string $slug);
    public function removeImage(Product $product);
    public function updateProduct(ProductRequest $request, Product $product);
    public function deleteProduct(Product $product);
}
