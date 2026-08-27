@extends('layouts.dashboard')

@section('content')
<<<<<<< HEAD
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
=======
    <h1 class="text-center fw-bold fs-1">Create Invoice</h1>
    <hr class="my-4">
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
    <form id="invoiceForm" action="{{ route('dashboard.invoices.update',['invoice'=>$invoice->id]) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="row g-3 mb-3">
            <div class="col">
                <label for="invoice_number">Invoice Number</label>
                <input id="invoice_number" value="{{ old('invoice_number',$invoice->invoice_number) }}" name="invoice_number" type="text" class="form-control"
                    placeholder="Invoice number">
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
                <input class="form-control" type="date" value="{{ old('due_date',$invoice->due_date->format('Y-m-d')) }}" name="due_date" id="">
                @error('due_date')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col">
                <label for="time">Client</label>
                <select class="form-control" name="client_id" id="">
                    <option value="">Select Client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ $client->id == $invoice->client_id ? 'selected' : '' }}>{{ $client->username }}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product
            +</button>



        {{-- Display Chooses  Products --}}
        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Original Price</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>

            </table>

        </div>
        <div class="row g-3 mb-3">
            <div id="totalAmount" class="col">
                Total: $<span>00</span>
            </div>
        </div>

        <input type="hidden" name="products_json" id="products_json">
        <button type="submit" class="btn btn-primary mt-3">Add</button>
    </form>
    {{-- Modal Add Product --}}
    <div class="modal fade" id="addProductModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Modal 1</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="formAddProduct">
                    <div class="modal-body">
                        <div class="row align-items-end">
                            <div class="col">
                                <label for="" class="form-label">Product</label>
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <input list="productInput" id="productSelect" class="form-control">
                                        <datalist id="productInput">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->slug }}" data-list="{{ $product->id }}"
                                                    data-price="{{ $product->price }}" data-base-quantity="{{ $product->quantity }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-3">
                                        <div id="priceDisplay" class="">$00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-9">
                                <label for="" class="form-label">Price</label>
                                <input id="priceInput" type="text" class="form-control">
                            </div>
                            <div class="col-3">
                                <label for="" class="form-label">Quantity</label>
                                <input id="quantityInput" type="number" value="1" min="1" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="" class="form-label">Description</label>
                                <textarea id="descriptionInput" name="" id="" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@php
    $selectedProducts = [];
    foreach($invoice->invoiceItems as $item) {
        $selectedProducts[$item->product_id] = [
            'product_id' => $item->product_id,
            'title' => $item->product->slug ?? $item->product->name,
            'basePrice' => $item->unit_price,
            'price' => $item->unit_price,
            'description' => $item->description,
            'quantity' => $item->quantity,
            'baseQuantity' => $item->product->quantity ?? 0,
            'oldQuantity' => $item->product->quantity + $item->quantity
        ];
    }
@endphp


@push('scripts')
    <script>
        $(document).ready(function() {
            let selectedProducts = @json($selectedProducts);


            addProduct();
            // choose product and display main price
            $(document).on('change keyup', '#productSelect', function() {
                let value = $(this).val();

                // check if use not select any product
                if (value === "") {
                    $('#priceDisplay').html("$00");
                    return;
                }

                let option = $('#productInput option[value="' + value + '"]');

                let price = option.data('price');
                let id = option.data('list');
                let baseQuantity = option.data('base-quantity');

                $('#quantityInput').attr('max',oldQuantity);
                $('#priceDisplay').html(price ? `$${price}` : '$00');
            });

            // add product selected to selectedProducts
            $(document).on('submit', '#formAddProduct', function(e) {
                e.preventDefault();

                let value = $('#productSelect').val()

                let option = $('#productInput option[value="' + value + '"]');

                let basePrice = option.data('price');
                let id = option.data('list');
                let baseQuantity = option.data('base-quantity');

                // check if user choose product
                if (!id) {
                    console.log('please enter product');
                    return;
                }

                let price = $('#priceInput').val();
                let description = $('#descriptionInput').val();

                let quantity = $('#quantityInput').val();

                selectedProducts[id] = {
                    product_id: id,
                    title: value,
                    basePrice: basePrice,
                    price: price,
                    description: description,
                    quantity: quantity,
                    baseQuantity: baseQuantity,
                    oldQuantity: selectedProducts[id].oldQuantity
                }

                // reset inputs
                $('#addProductModal').modal('hide')
                $('#productSelect').val('')
                $('#priceDisplay').html('$00')
                $('#descriptionInput').val('')
                $('#priceInput').val('')


                addProduct()

            });



            // display product in html
            function addProduct() {
                calculateTotal()
                let productTable = ''
                for (let key in selectedProducts) {
                    let product = selectedProducts[key];
                    productTable += `
                        <tr>
                            <td>${key}</td>
                            <td>${product.title}</td>
                            <td>${product.basePrice}</td>
                            <td>${product.price}</td>
                            <td><input min='1' max='${product.oldQuantity}' class='form-control quantityEditInput' type='number' value='${Number(product.quantity)}' data-id='${key}'></td>
                            <td>
                                <button type='button' class='btn btn-danger removeProduct' data-id='${key}'>
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                }
                $('#tbody').html(productTable);
            }

            // button to remove product from selectedProducts
            $(document).on('click', '.removeProduct',function() {
                let id = $(this).data('id');

                delete selectedProducts[id];

                addProduct()
            })

            // control in quantity product
            $(document).on('change', '.quantityEditInput',function() {
                let id = $(this).data('id');
                let value = $(this).val();

                selectedProducts[id].quantity = value;
                calculateTotal()
            })

            // calce total Amount for all product selected
            function calculateTotal() {
                let products = [];
                for (let id in selectedProducts) {
                    products.push(selectedProducts[id]);
                }
                $('#products_json').val(JSON.stringify(products));
                let total = 0;
                for (let id in selectedProducts) {
                    let price = parseFloat(selectedProducts[id].price) || selectedProducts[id].basePrice;
                    let quantity = parseInt(selectedProducts[id].quantity);
                    total += price * quantity;
                }
                $('#totalAmount span').html(total.toFixed(2));
>>>>>>> Edit
            }
        });
    </script>
@endpush
