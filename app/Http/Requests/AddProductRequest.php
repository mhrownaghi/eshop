<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddProductRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|integer|exists:product_categories,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
            'height' => 'nullable|numeric|gt:0',
            'diagonal' => 'nullable|numeric|gt:0',
            'volume' => 'nullable|numeric|gt:0',
            'weight' => 'nullable|numeric|gt:0',
            'box' => 'nullable|integer|gt:0',
            'price' => 'nullable|numeric|gt:0',
            'old_price' => 'nullable|numeric|gt:price',
            'additional_price' => 'nullable|numeric|gt:0',
            'can_increase_price' => 'sometimes|boolean',
            'is_stock' => 'sometimes|boolean',
            'stock' => 'nullable|integer|gt:0',
            'sku' => 'required|integer|gt:0|unique:products,sku',
            'type' => [
                'required',
                Rule::in(['lid', 'box', 'other']),
            ],
            'has_selectable_lid' => 'sometimes|boolean',
            'has_selectable_box' => 'sometimes|boolean',
            'offline_shopping' => 'sometimes|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'can_increase_price' => $this->boolean('can_increase_price'),
            'is_stock' => $this->boolean('is_stock'),
            'has_selectable_lid' => $this->boolean('has_selectable_lid'),
            'has_selectable_box' => $this->boolean('has_selectable_box'),
        ]);
    }

}
