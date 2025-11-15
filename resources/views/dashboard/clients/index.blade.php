@extends('layouts.dashboard')

@section('content')
        <div class="table-responsive overflow-auto h-50 mt-5 rounded-4">
            <table class="table table-hover table-warning table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Addess</th>
                        <th scope="col">User</th>
                        <th scope="col">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <th scope="row">{{ $loop->iteration + $clients->firstItem() - 1 }}</th>
                            <td>{{ $client->username }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->phone }}</td>
                            <td>{{ $client->address }}</td>
                            <td>{{ $client->user->name }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <a href="{{ route('dashboard.clients.show',['client' => $client->id]) }}" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('dashboard.clients.edit',['client' => $client->id]) }}" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <button type="button"
                                        class="btn btn-danger openDeleteModal"
                                        data-id="{{ $client->id }}"
                                        data-url="{{ route('dashboard.clients.destroy', ['client' => $client->id]) }}"
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
                                <h5 class="modal-title">Delete Client</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                Are you sure you want to delete this client?
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{ $clients->links('pagination::bootstrap-5') }}
        </div>
@endsection
