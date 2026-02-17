<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductImageRequest extends FormRequest
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
            'path' => 'required|image|mimes:jpeg,png,jpg,webp|max:2024',
            'alt' => 'required|string|max:255',
            'is_thumb' => 'sometimes|boolean',
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
