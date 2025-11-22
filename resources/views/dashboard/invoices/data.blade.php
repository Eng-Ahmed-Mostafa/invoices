<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr>
                <td></td>
                <td>{{ $product->slug }}</td>
                <td>
                    <input type="number" min="1" class="form-control product-qty" data-id="{{ $product->id }}"
                        value="1">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
