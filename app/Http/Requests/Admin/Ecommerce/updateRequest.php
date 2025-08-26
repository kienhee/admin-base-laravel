<?php

namespace App\Http\Requests\Admin\Ecommerce;

use Illuminate\Foundation\Http\FormRequest;

class updateRequest extends FormRequest
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
        $productId = $this->route('id'); // assuming route model binding or 'product' param
        return [
            'title' => 'required|string|unique:products,title,' . $productId,
            'slug' => 'nullable|string|unique:products,slug,' . $productId,
            'sku' => 'nullable|string',
            'barcode' => 'nullable|string',
            'description' => 'nullable|string',
            'images' => 'required|string',
            'variants' => 'required|array|min:1',
            'variants.*.option' => 'required|string',
            'variants.*.value' => 'required|string',
            'base_price' => 'required|string|regex:/^[0-9\\.]+$/',
            'sale_price' => 'nullable|string|regex:/^[0-9\\.]+$/',
            'is_tax' => 'nullable|boolean',
            'is_in_stock' => 'nullable',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'category_id' => 'required|integer|exists:categories,id',
            'collection_id' => 'required|integer|exists:collections,id',
            'status' => 'required|in:published,scheduled,inactive',
            'hashtags' => 'required|array',
            'hashtags.*' => 'integer|exists:hash_tags,id',
        ];
    }
}
