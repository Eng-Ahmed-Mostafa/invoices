@extends('layouts.dashboard')

@section('content')
        <div class="table-responsive overflow-auto h-50 mt-5 rounded-4">
            <table class="table table-hover table-warning table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Client id</th>
                        <th scope="col">Invoice date</th>
                        <th scope="col">Due date</th>
                        <th scope="col">Total amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <th scope="row">{{ $loop->iteration + $invoices->firstItem() - 1 }}</th>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->cart->client->username }}</td>
                            <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                            <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
                            <td>${{ $invoice->total_amount }}</td>
                            <td><span class="badge {{ $invoice->status == 'unpaid' ? 'text-bg-secondary' : 'text-bg-primary' }}">{{ $invoice->status }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <a href="{{ route('dashboard.invoices.show',['invoice' => $invoice->id]) }}" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('dashboard.invoices.edit',['invoice' => $invoice->id]) }}" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <button type="button"
                                        class="btn btn-danger openDeleteModal"
                                        data-id="{{ $invoice->id }}"
                                        data-url="{{ route('dashboard.invoices.destroy', ['invoice' => $invoice->id]) }}"
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
                                <h5 class="modal-title">Delete Invoice</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                Are you sure you want to delete this Invoice?
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{ $invoices->links('pagination::bootstrap-5') }}
        </div>
@endsection
