@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Details Invoice</h1>
    <hr class="my-4">
    <p class="mb-0 fw-bold">client Details</p>
    <ul class="list-unstyled ps-4">
        <li>name: {{ $cart->client->username }}</li>
        <li>email: {{ $cart->client->email }}</li>
        <li>phone: {{ $cart->client->phone }}</li>
    </ul>
    <p class="mb-0 fw-bold">Product Details</p>
    <div class="table-responsive overflow-auto h-50 mt-5 rounded-4">
            <table class="table table-hover table-warning table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Image</th>
                        <th scope="col">Price</th>
                        <th scope="col">User</th>
                        <th scope="col">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart->products as $product)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>
                                {{ $product->title }}
                                <br>
                                <span class="text-secondary">{{ $product->slug }}</span>
                            </td>
                            <td>
                                <img class="rounded-4" src="{{ asset('storage/'.$product->image) }}" alt="" width="40" height="40">
                            </td>
                            <td>${{ $product->price }}</td>
                            <td>{{ $product->user->name }}</td>
                            <td>{{ $product->pivot->quantity }}</td>

                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
@endsection