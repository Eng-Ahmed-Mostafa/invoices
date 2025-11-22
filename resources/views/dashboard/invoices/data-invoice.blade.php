
    @foreach ($invoices as $invoice)
        <tr>
            <th scope="row">{{ $loop->iteration + $invoices->firstItem() - 1 }}</th>
            <td>{{ $invoice->invoice_number }}</td>
            <td>{{ $invoice->client->username }}</td>
            <td>{{ $invoice->client->address }}</td>
            <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
            <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
            <td>${{ $invoice->total_amount }}</td>
            <td>
                <span class="badge {{ $invoice->status == 'unpaid' ? 'text-bg-secondary' : 'text-bg-primary' }}">
                    {{ $invoice->status }}
                </span>
            </td>
            <td>
                <div class="d-flex align-items-center gap-1">
                    <a href="{{ route('dashboard.invoices.show', $invoice->id) }}" class="btn btn-primary">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="{{ route('dashboard.invoices.edit', $invoice->id) }}" class="btn btn-success">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    
                    <button type="button" class="btn btn-danger openDeleteModal"
                        data-url="{{ route('dashboard.invoices.destroy', $invoice->id) }}"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
