@extends('layouts.dashboard')

@section('content')
        <div class="table-responsive overflow-auto h-50 mt-5 rounded-4">
            <table class="table table-hover table-warning table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Image</th>
                        <th scope="col">Price</th>
                        <th scope="col">User</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row">{{ $loop->iteration + $products->firstItem() - 1 }}</th>
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
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <a href="{{ route('dashboard.products.show',['product'=>$product->id]) }}" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('dashboard.products.edit',['product' => $product->id]) }}" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <button type="button"
                                        class="btn btn-danger openDeleteModal"
                                        data-id="{{ $product->id }}"
                                        data-url="{{ route('dashboard.products.destroy', ['product' => $product->id]) }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteClientModal">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
            <!-- Delete Modal -->
            <div class="modal" id="deleteClientModal" tabindex="-1">
                <div class="modal-dialog">
                    <form id="deleteClientForm"  method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                Are you sure you want to delete this Product?
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
@endsection
