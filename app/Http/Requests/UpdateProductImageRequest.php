<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductImageRequest extends FormRequest
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
        /** @var \App\Models\ProductImage $productImage */
        $productImage = $this->route('product_image');
        return [
            'alt' => 'required|string|max:255',
            'is_thumb' => [
                'sometimes',
                'boolean',
                function ($attribute, $value, $fail) use ($productImage) {
                    if ($productImage->is_thumb && !$value) {
                        $fail('The thumb field must not be false');
                    }
                },
            ],
        ];
    }
    
    #[\Override]
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_thumb' => $this->boolean('is_thumb'),
        ]);
    }
}
