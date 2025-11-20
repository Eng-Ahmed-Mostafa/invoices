@extends('layouts.dashboard')

@section('content')
    <h1 class="text-center fw-bold fs-1">Details Invoice</h1>
    <hr class="my-4">
    <a href="{{ route('dashboard.invoices.pdf',['invoice'=>$invoice->id]) }}"  class="btn btn-primary  mb-3" >
        <i class="fa-solid fa-file-pdf"></i> Export PDF
    </a>
    <div id="details">
        <h3>Invoice number: {{ $invoice->invoice_number }}</h3>
    <p>Invoice date: {{ $invoice->invoice_date->format('Y-m-d') }}</p>
    <p>Due date: {{ $invoice->due_date->format('Y-m-d') }}</p>
    <p>Total: ${{ $invoice->total_amount }}</p>
    <p class="badge {{ $invoice->status == 'unpaid' ? 'text-bg-secondary' : 'text-bg-primary' }}">{{ $invoice->status }}</p>
    <p class="mb-0 fw-bold">client Details</p>
    <ul class="list-unstyled ps-4">
        <li>name: {{ $invoice->client->username }}</li>
        <li>email: {{ $invoice->client->email }}</li>
        <li>phone: {{ $invoice->client->phone }}</li>
    </ul>
    <p class="mb-0 fw-bold">Product Details</p>
    <div class="table-responsive overflow-auto h-50 mt-5 rounded-4">
            <table class="table table-hover table-warning table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Image</th>
                        <th scope="col">Unit price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->invoiceItems as $product)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>
                                {{ $product->product->title }}
                                <br>
                                <span class="text-secondary">{{ $product->product->slug }}</span>
                            </td>
                            <td>
                                <img class="rounded-4" src="{{ asset('storage/'.$product->product->image) }}" alt="" width="40" height="40">
                            </td>
                            <td>${{ $product->unit_price }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>${{ $product->unit_price * $product->quantity }}</td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        async function downloadInvoicesPDF() {
            const table = document.querySelector('#details');
            table.classList.add('container-fluid','py-4');
            const canvas = await html2canvas(table, { scale: 2 });
            table.classList.remove('container-fluid','py-4');

            const imgData = canvas.toDataURL('image/png');
            const { jsPDF } = window.jspdf;

            const pdf = new jsPDF('p', 'pt', 'a4');

            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('invoices.pdf');
        }
    </script>

@endpush