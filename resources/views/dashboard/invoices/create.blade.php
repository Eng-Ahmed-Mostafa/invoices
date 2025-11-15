@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Create Invoice</h1>
    <hr class="my-4">
    <form action="{{ route('dashboard.invoices.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col">
                <label for="invoice_number">invoice number</label>
                <input id="invoice_number"  name="invoice_number" type="text" class="form-control" placeholder="Invoice number" aria-label="Invoice number">
                @error('invoice_number')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <label for="time">Due time</label>
                <input id="time" name="due_time" type="number" min="1" class="form-control" placeholder="Due Time" aria-label="Due Time">
                @error('due_time')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <label for="carts">Client Cart</label>
                <select id="carts" name="cart_id" class="form-select">
                    <option value="">Cart</option>
                    @foreach ($carts as $cart)
                        <option value="{{ $cart->id }}">{{ $cart->client->username }}: number of cart {{ $cart->id }}</option>
                    @endforeach
                </select>
                @error('cart_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <button class="btn btn-primary mt-3">Add</button>
    </form>
@endsection