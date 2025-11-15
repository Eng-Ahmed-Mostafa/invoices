@extends('layouts.dashboard')

@section('content')
        <div class="table-responsive overflow-auto h-50 mt-5 rounded-4">
            <table class="table table-hover table-warning table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Client</th>
                        <th scope="col">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($carts as $cart)
                        <tr>
                            <th scope="row">{{ $loop->iteration + $carts->firstItem() - 1 }}</th>
                            <td>{{ $cart->client->username }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <a href="{{ route('dashboard.carts.show',['cart' => $cart->id]) }}" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('dashboard.carts.edit',['cart' => $cart->id]) }}" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <button type="button"
                                        class="btn btn-danger openDeleteModal"
                                        data-id="{{ $cart->id }}"
                                        data-url="{{ route('dashboard.carts.destroy', ['cart' => $cart->id]) }}"
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
                                <h5 class="modal-title">Delete Cart</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                Are you sure you want to delete this Cart?
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{ $carts->links('pagination::bootstrap-5') }}
        </div>
@endsection
