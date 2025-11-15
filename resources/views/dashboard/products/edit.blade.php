@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Edit Product</h1>
    <hr class="my-4">
    <form action="{{ route('dashboard.products.update',['product'=> $product->id]) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row g-3">
            <div class="col">
                <label for="title">Title</label>
                <input id="title" type="text" value="{{ old('title',$product->title) }}" name="title" class="form-control" placeholder="Product number" aria-label="Product number">
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <label for="slug">Slug</label>
                <input id="slug" type="text" value="{{ old('slug',$product->slug) }}" name="slug" class="form-control" placeholder="Product number" aria-label="Product number">
                @error('slug')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row g-3">
            <div class="col">
                <label for="price">price</label>
                <input id="price" type="number" value="{{ old('price',$product->price) }}" name="price" min="1" class="form-control" placeholder="Product number" aria-label="Product number">
                @error('price')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <label for="image">Image</label>
                <input id="image" type="file" name="image" class="form-control" placeholder="Product number" aria-label="Product number">
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <button class="btn btn-primary mt-3">Edit</button>
    </form>
@endsection