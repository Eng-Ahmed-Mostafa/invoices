@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Create Product</h1>
    <hr class="my-4">
    <form action="{{ route('dashboard.clients.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col">
                <label for="username">Username</label>
                <input id="username" type="text" class="form-control" placeholder="Username" name="username" aria-label="Username">
                @error('username')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label for="email">Email</label>
                <input id="email" type="eamil" class="form-control" placeholder="Email" name="email" aria-label="Email">
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row g-3">
            <div class="col">
                <label for="phone">Phone</label>
                <input id="phone" type="text" class="form-control" placeholder="Phone" name="phone" aria-label="Phone">
                @error('phone')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label for="address">Address</label>
                <input id="address" type="text" class="form-control" placeholder="Address" name="address" aria-label="Address">
                @error('address')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <label for="note">Note</label>
                <textarea class="form-control" name="note" id="note"></textarea>
                @error('note')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <button class="btn btn-primary mt-3">Add</button>
    </form>
@endsection