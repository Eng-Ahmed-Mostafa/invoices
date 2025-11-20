<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        #details {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e9ecef;
        }
    </style>

</head>
<body>
    <div id="details" class="p-4">
        <h1 class="text-center fw-bold fs-1">Invoice Details</h1>
        <hr class="my-4">
        <h3 class="mb-3">Invoice #{{ $invoice->id }}</h3>
        <ul class="list-unstyled mb-4">
            <li>date: {{ $invoice->created_at->format('Y-m-d') }}</li>
            <li>due date: {{ $invoice->due_date->format('Y-m-d') }}</li>
        </ul>
        <h3 class="mb-3">Client Information</h3>
        <ul class="list-unstyled mb-4"></ul>
            <li>name: {{ $invoice->client->username }}</li>
            <li>email: {{ $invoice->client->email }}</li>
            <li>phone: {{ $invoice->client->phone }}</li>
        </ul>
        <h3 class="mb-3">Products</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Unit price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->invoiceItems as $product)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $product->product->title }}</td>
                        <td>${{ $product->unit_price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>${{ $product->unit_price * $product->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3 class="text-end mt-4">Total Amount: ${{ $invoice->total_amount }}</h3>
    </div>
</body>
</html>