@extends('layouts.dashboard')

@section('content')
<h1 class="text-center fw-bold fs-1">Edit Invoice</h1>
<hr class="my-4">

<form id="invoiceForm" action="{{ route('dashboard.invoices.update',['invoice'=> $invoice->id]) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="row g-3 mb-3">
        <div class="col">
            <label for="invoice_number">Invoice Number</label>
            <input id="invoice_number" name="invoice_number" value="{{ old('invoice_number',$invoice->invoice_number) }}" type="text" class="form-control" placeholder="Invoice number">
            @error('invoice_number')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="col">
            <label for="time">Invoice Date</label>
            <input class="form-control" type="date" value="{{ old('invoice_date',$invoice->invoice_date->format('Y-m-d')) }}" name="invoice_date" id="">
            @error('invoice_date')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col">
            <label for="time">Due Date</label>
            <input class="form-control" value="{{ old('due_date',$invoice->due_date->format('Y-m-d')) }}" type="date" name="due_date" id="">
            @error('due_time')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="col">
            <label for="time">Client</label>
            <select class="form-control" name="client_id" id="">
                <option value="">Select Client</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ $invoice->client_id == $client->id ? 'selected' : '' }}>{{ $client->username }}</option>
                @endforeach
            </select>
            @error('client_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col">
            <label for="time">Total</label>
            <input id="totalAmount" type="text" value="{{ old('total_amount', number_format($invoice->total_amount,2)) }}" name="total_amount" id="" readonly class="form-control">
            @error('total_amount')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="table-responsive">
        <div id="productsWrapper">
                @include('dashboard.invoices.data-edit')
            </div>
    </div>

    <input type="hidden" name="products_json" id="products_json">
    <button type="submit" class="btn btn-primary mt-3">Edit</button>
</form>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let selectedProducts = {};

            $('.product-checkbox').each(function() {
                const id = $(this).data('id');
                const price = Number($(this).data('price'));
                const qtyInput = $('.product-qty[data-id="' + id + '"]');

                if ($(this).is(':checked')) {
                    const qty = Number(qtyInput.val());
                    selectedProducts[id] = {
                        quantity: qty,
                        price: price
                    };
                }
            });

            $('#totalAmount').val(calculateTotal()); 


            // when change checkbox
            $(document).on('change', '.product-checkbox', function() {
                const id = $(this).data('id');
                const price = Number($(this).data('price'));
                const qtyInput = $('.product-qty[data-id="' + id + '"]'); 

                if ($(this).is(':checked')) {
                    const qty = Number(qtyInput.val());
                    selectedProducts[id] = {
                        quantity: qty,
                        price: price
                    };
                } else {
                    delete selectedProducts[id];
                }

                $('#totalAmount').val(calculateTotal());
            });

            // when change qty
            $(document).on('change', '.product-qty', function() {
                const id = $(this).data('id');
                const qty = Number($(this).val());

                if (selectedProducts[id]) {
                    selectedProducts[id].quantity = qty;
                }

                $('#totalAmount').val(calculateTotal());
            });

            // calculate total amount
            function calculateTotal() {
                let total = 0;
                for (let id in selectedProducts) {
                    // console.log(id);
                    
                    total += selectedProducts[id].price * selectedProducts[id].quantity;
                }
                return total.toFixed(2);
            }

            // save data on form submit
            $('#invoiceForm').submit(function(e) {
                if (Object.keys(selectedProducts).length === 0) {
                    e.preventDefault();
                    alert('Please select at least one product.');
                    return false;
                }

                let products = [];
                for (let id in selectedProducts) {
                    products.push({
                        product_id: Number(id),
                        quantity: selectedProducts[id].quantity
                    });
                }

                $('#products_json').val(JSON.stringify(products));
            });

            // change pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                fetch_data($(this).attr('href'));
            });

            function fetch_data(url) {
                $.ajax({
                    method: "GET",
                    url: url,
                    dataType: "html",
                    success: function(data) {
                        $('#productsWrapper').html(data);

                        for (let id in selectedProducts) {
                            const checkbox = $('.product-checkbox[data-id="' + id + '"]');
                            const qtyInput = $('.product-qty[data-id="' + id + '"]');

                            if (checkbox.length) {
                                checkbox.prop('checked', true);
                                qtyInput.val(selectedProducts[id].quantity);
                            }
                        }

                        $('#totalAmount').val(calculateTotal());
                    }
                });
            }
        });
    </script>
@endpush
