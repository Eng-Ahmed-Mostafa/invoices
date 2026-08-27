<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'title'=> 'required|max:255',
            'slug'=> ['required', 'max:255', Rule::unique('products', 'slug')->whereNull('deleted_at')->ignore($this->route('product'))],
            'image'=> 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
            'price'=> 'required|numeric|min:0',
            'quantity'=> 'required|integer|min:0',
            'description'=> 'nullable|string',
        ];
    }
}
