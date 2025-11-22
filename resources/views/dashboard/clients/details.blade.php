@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Details Invoice</h1>
    <hr class="my-4">
    <h3>{{ $client->username }}</h3>
    <p>Email: {{ $client->email }}</p>
    <p>Phone: {{ $client->phone }}</p>
    <p>address: {{ $client->address }}</p>
    @if (!empty($client->note))
        <p>note: {{ $client->note }}</p>
    @endif
    <p class="mb-0 fw-bold">User Details</p>
    <ul class="list-unstyled ps-4">
        <li>name: {{ $client->user->name }}</li>
        <li>email: {{ $client->user->email }}</li>
    </ul>

    @if ($invoices->count() > 0)
        <div class="table-responsive overflow-auto h-50 mt-5 rounded-4">
            <table class="table table-hover table-warning table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Number</th>
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
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                            <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
                            <td>${{ $invoice->total_amount }}</td>
                            <td>
                                <span
                                    class="badge {{ $invoice->status == 'unpaid' ? 'text-bg-secondary' : 'text-bg-primary' }}">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <a href="{{ route('dashboard.invoices.show', $invoice->id) }}" class="btn btn-primary">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    {{-- <a href="{{ route('dashboard.invoices.edit', $invoice->id) }}" class="btn btn-success">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button type="button" class="btn btn-danger openDeleteModal"
                                    data-url="{{ route('dashboard.invoices.destroy', $invoice->id) }}" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-trash"></i>
                                </button> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
