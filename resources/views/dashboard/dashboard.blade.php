@extends('layouts.dashboard')

@section('content')
        <div class="row row-cols-3 g-4">
            <div class="col">
                <div class="text-bg-primary rounded-4 p-3">
                    <h3 class="fs-3 fw-bold">Invoices</h3>
                    <span class="fs-1">{{ $invoices->count() }}</span>
                </div>
            </div>
            <div class="col">
                <div class="text-bg-success rounded-4 p-3">
                    <h3 class="fs-3 fw-bold">Total sales amount</h3>
                    <span class="fs-1">{{ $invoices->sum('total_amount') }}</span>
                </div>
            </div>
            <div class="col">
                <div class="text-bg-warning rounded-4 p-3">
                    <h3 class="fs-3 fw-bold">Total Products</h3>
                    <span class="fs-1">{{ $totalProducts }}</span>
                </div>
            </div>
            <div class="col">
                <div class="text-bg-info rounded-4 p-3">
                    <h3 class="fs-3 fw-bold">Total Clients</h3>
                    <span class="fs-1">{{ $totalCustomers }}</span>
                </div>
            </div>
            <div class="col">
                <div class="text-bg-danger rounded-4 p-3">
                    <h3 class="fs-3 fw-bold">Total users</h3>
                    <span class="fs-1">{{ $totalUsers }}</span>
                </div>
            </div>
        </div>
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
                        <th scope="col">status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->cart->client->username }}</td>

                            <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                            <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
                            <td>${{ $invoice->total_amount }}</td>
                            <td><span class="badge {{ $invoice->status == 'unpaid'? 'text-bg-secondary' : 'text-bg-primary' }}">unpaid</span></td>
                        </tr>
                        
                    @endforeach
                    
                </tbody>
            </table>
        </div>
@endsection
