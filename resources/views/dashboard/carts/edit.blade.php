@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Edit Cart</h1>
    <hr class="my-4">
    <form action="{{ route('dashboard.carts.update', $cart->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mt-2">
            <div class="col">
                <label for="client_id">Client</label>
                <select id="client_id" name="client_id" class="form-select">
                    <option value="">Client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ $cart->client_id == $client->id ? 'selected' : '' }}>{{ $client->username }}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <label for="Quantity">Quantity</label>
                <input id="Quantity" name="quantity" type="number" min="1" class="form-control" placeholder="Quantity" aria-label="Quantity" value="{{ old('quantity', $cart->products->first()->pivot->quantity ?? '') }}">
                @error('quantity')
                    <p class="text-danger">{{ $message }}</p>
                @enderror            
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <label for="products">Product</label>
                <select id="products" name="product" class="form-select">
                    <option value="">Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $cart->products->contains($product->id) ? 'selected' : '' }}>{{ $product->slug }} : ${{ $product->price }}</option>
                    @endforeach
                </select>
                @error('products')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <button class="btn btn-primary mt-3">Update</button>

    </form>
@endsection