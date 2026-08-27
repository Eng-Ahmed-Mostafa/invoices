@extends('layouts.dashboard')

<<<<<<< HEAD
@section('content') 
        <button class="btn btn-primary mb-3" onclick="downloadInvoicesPDF()">
            <i class="fa-solid fa-file-pdf"></i> Export PDF
        </button>

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
                            <td>{{ $invoice->client->username }}</td>
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
=======
@section('content')
    @push('header')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    {{-- <button class="btn btn-primary mb-3" onclick="downloadInvoicesPDF()">
            <i class="fa-solid fa-file-pdf"></i> Export PDF
        </button> --}}
    <input type="seaxrch" id="searchInput" class="form-control mb-3" placeholder="Search invoices Number or Client">
    <div class="table-responsive overflow-auto h-50 mt-5 rounded-4">
        <table class="table table-hover table-warning table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Invoice Number</th>
                    <th scope="col">Client</th>
                    <th scope="col">Address</th>
                    <th scope="col">Invoice date</th>
                    <th scope="col">Due date</th>
                    <th scope="col">Total amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody id="invoicesTableBody">
                @include('dashboard.invoices.data-invoice')
            </tbody>
>>>>>>> Edit

        </table>
        <!-- Delete Modal -->
        <div class="modal" id="deleteModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="deleteClientForm" method="POST">
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
        <div id="paginationWrapper">
            @include('dashboard.invoices.invoices-pagination')
        </div>
    </div>
@endsection

<<<<<<< HEAD
@push('scripts')
=======


@push('scripts')
    <script>
        $(document).ready(function() {

            // Handle search
            $('#searchInput').on('keyup', function() {
                console.log($(this).val());

                fetchInvoices($(this).val());
            });

            // Handle pagination (needs event delegation)
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                const pageUrl = $(this).attr('href');
                fetchInvoices($('#searchInput').val(), pageUrl);
            });

            function fetchInvoices(query = '', pageUrl = '{{ route('dashboard.invoices.index') }}') {
                $.ajax({
                    url: pageUrl,
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        $('#invoicesTableBody').html(response.table);
                        $('#paginationWrapper').html(response.pagination);
                    },
                    error: function(err) {
                        console.log(err.status);
                        console.log(err.responseText);
                    }
                });

            }

            let deleteUrl;
            // Open delete modal (event delegation)
            $(document).on('click', '.openDeleteModal', function() {
                deleteUrl = $(this).data('url');
                console.log(deleteUrl)
                $('#deleteModal').modal('show'); // افتح المودال
            });

            // Confirm delete
            $(document).on('click', '#deleteClientForm button[type="submit"]', function(e) {
                e.preventDefault();
                if (!deleteUrl) return;

                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        fetchInvoices($('#searchInput').val());
                    }
                });
            });
        });
    </script>
@endpush
{{-- @push('scripts')
>>>>>>> Edit
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        async function downloadInvoicesPDF() {
            const table = document.querySelector('.table-responsive');
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

<<<<<<< HEAD
@endpush
=======
@endpush --}}
>>>>>>> Edit
