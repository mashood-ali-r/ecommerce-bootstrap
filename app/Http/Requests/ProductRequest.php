<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all for now
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product');
        
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $productId,
            'sku' => 'required|string|max:255|unique:products,sku,' . $productId,
            'description' => 'required|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0|gt:price',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_flash_deal' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category',
            'category_id.exists' => 'Selected category does not exist',
            'name.required' => 'Product name is required',
            'slug.required' => 'Product slug is required',
            'slug.unique' => 'This slug is already in use',
            'sku.required' => 'SKU is required',
            'sku.unique' => 'This SKU is already in use',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'old_price.gt' => 'Old price must be greater than current price',
            'stock.required' => 'Stock quantity is required',
        ];
    }
}
