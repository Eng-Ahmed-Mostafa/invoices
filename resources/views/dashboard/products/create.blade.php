@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Create Product</h1>
    <hr class="my-4">
    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col">
                <label for="title">Title</label>
                <input id="title" type="text" name="title" class="form-control" placeholder="title" aria-label="">
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <label for="slug">Slug</label>
                <input id="slug" type="text" name="slug" class="form-control" placeholder="slug" aria-label="">
                @error('slug')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row g-3">
            <div class="col">
                <label for="price">price</label>
                <input id="price" type="number" name="price" min="1" class="form-control" placeholder="price" aria-label="">
                @error('price')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <label for="quantity">quantity</label>
                <input id="quantity" type="number" min="1" name="quantity" min="1" class="form-control" placeholder="quantity" aria-label="">
                @error('quantity')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row g-3">
            <div class="col">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="description" aria-label=""></textarea>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row g-3">
            <div class="col">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div id="image" class="row g-3 mt-2 hidden">
            <img class="image-fluid object-fit-cover w-100" src="" alt="">
        </div>
        <button class="btn btn-primary mt-3">Add</button>
    </form>
@endsection

@push('scripts')
    <script>
        $('#title').on('input', function() {
            let title = $(this).val();
            let slug = title.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            $('#slug').val(slug);
        });
        $('[type="file"]').on('change', function() {
            const [file] = this.files;
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image').removeClass('hidden');
                    $('#image img').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush