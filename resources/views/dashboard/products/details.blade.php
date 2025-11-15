@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Details Invoice</h1>
    <hr class="my-4">
    <h3>{{ $product->title }}</h3>
    <p>Slug: {{ $product->slug }}</p>
    <img class="rounded-4" src="{{ asset('storage/'.$product->image) }}" alt="" width="200" height="200">
    <p>Price: ${{ $product->price }}</p>
    <p class="mb-0 fw-bold">User Details</p>
    <ul class="list-unstyled ps-4">
        <li>name: {{ $product->user->name }}</li>
        <li>email: {{ $product->user->email }}</li>
    </ul>
@endsection