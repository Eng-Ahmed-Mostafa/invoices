@extends('layouts.dashboard')

@section('content')
    <div class=" bg-light rounded-4  p-3 shadow-sm">
        <div class="row row-cols-3 g-4">
            <div class="col">
                <div class="text-bg-primary rounded-4 p-3">
                    <h3 class="fs-3 fw-bold">Invoices</h3>
                    <span class="fs-1">9</span>
                </div>
            </div>
            <div class="col">
                <div class="text-bg-success rounded-4 p-3">
                    <h3 class="fs-3 fw-bold">Total sales amount</h3>
                    <span class="fs-1">10</span>
                </div>
            </div>
            <div class="col">
                <div class="text-bg-warning rounded-4 p-3">
                    <h3 class="fs-3 fw-bold">Total Products</h3>
                    <span class="fs-1">9</span>
                </div>
            </div>
            <div class="col">
                <div class="text-bg-info rounded-4 p-3">
                    <h3 class="fs-3 fw-bold">Total customers</h3>
                    <span class="fs-1">9</span>
                </div>
            </div>
            <div class="col">
                <div class="text-bg-danger rounded-4 p-3">
                    <h3 class="fs-3 fw-bold">Total users</h3>
                    <span class="fs-1">9</span>
                </div>
            </div>
        </div>
        <div class="table-responsive overflow-auto h-50 mt-5 rounded-4">
            <table class="table table-hover table-warning table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">User id</th>
                        <th scope="col">Client id</th>
                        <th scope="col">Invoice date</th>
                        <th scope="col">Due date</th>
                        <th scope="col">Total amount</th>
                        <th scope="col">status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>1003</td>
                        <td>3</td>
                        <td>5</td>
                        <td>2005-2-29</td>
                        <td>2005-4-15</td>
                        <td>$1200</td>
                        <td><span class="badge text-bg-secondary">unpaid</span></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection
