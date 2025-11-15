@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Details Invoice</h1>
    <hr class="my-4">
    <h3>{{ $client->username }}</h3>
    <p>Email: {{ $client->email }}</p>
    <p>Phone: {{ $client->phone }}</p>
    <p >address: {{ $client->address }}</p>
    @if (!empty($client->note))
        <p>note: {{ $client->note }}</p>
    @endif
    <p class="mb-0 fw-bold">User Details</p>
    <ul class="list-unstyled ps-4">
        <li>name: {{ $client->user->name }}</li>
        <li>email: {{ $client->user->email }}</li>
    </ul>
    
@endsection