@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Create Product</h1>
    <hr class="my-4">
    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col">
                <label for="title">Title</label>
                <input id="title" type="text" name="title" class="form-control" placeholder="Invoice number" aria-label="Invoice number">
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <label for="slug">Slug</label>
                <input id="slug" type="text" name="slug" class="form-control" placeholder="Invoice number" aria-label="Invoice number">
                @error('slug')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row g-3">
            <div class="col">
                <label for="price">price</label>
                <input id="price" type="number" name="price" min="1" class="form-control" placeholder="Invoice number" aria-label="Invoice number">
                @error('price')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <label for="image">Image</label>
                <input id="image" type="file" name="image" class="form-control" placeholder="Invoice number" aria-label="Invoice number">
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <button class="btn btn-primary mt-3">Add</button>
    </form>
@endsection