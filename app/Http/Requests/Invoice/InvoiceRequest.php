<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "invoice_number" => "required|unique:invoices,invoice_number",
            "invoice_date" => "required|date|after_or_equal:today",
            "due_date" => "required|date|after_or_equal:invoice_date",
            'products_json' => 'required|json',
            'client_id' => 'required|exists:clients,id'
        ];
    }
}
