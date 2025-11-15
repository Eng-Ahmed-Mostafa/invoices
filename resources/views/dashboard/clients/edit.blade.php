@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Edit Product</h1>
    <hr class="my-4">
    <form action="{{ route('dashboard.clients.update',['client'=>$client->id]) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="row g-3">
            <div class="col">
                <label for="username">Username</label>
                <input id="username" type="text" class="form-control" placeholder="Username" value="{{ old('username',$client->username) }}" name="username" aria-label="Username">
                @error('username')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label for="email">Email</label>
                <input id="email" type="eamil" class="form-control" placeholder="Email" value="{{ old('email',$client->email) }}" name="email" aria-label="Email">
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row g-3">
            <div class="col">
                <label for="phone">Phone</label>
                <input id="phone" type="text" class="form-control" placeholder="Phone" value="{{ old('phone',$client->phone) }}" name="phone" aria-label="Phone">
                @error('phone')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label for="address">Address</label>
                <input id="address" type="text" class="form-control" placeholder="Address" value="{{ old('address',$client->address) }}" name="address" aria-label="Address">
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
        
        <button class="btn btn-primary mt-3">Edit</button>
    </form>
@endsection