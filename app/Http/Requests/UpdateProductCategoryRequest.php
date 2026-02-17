<?php

namespace App\Http\Requests;

use App\Models\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateProductCategoryRequest extends FormRequest
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
        /** @var ProductCategory $category */
        $category = $this->route('product_category');
        $categoryId = $category?->id;

        return [
            'name' => 'required|string|max:255|unique:product_categories,name,' . $categoryId,
            'parent_id' => [
                'nullable',
                'integer',
                'exists:product_categories,id',
                'not_in:' . $categoryId,
                function ($attribute, $value, $fail) use ($category) {
                    if ($value) {
                        $descendants = $category->getAllDescendantIds();
                        if (in_array((int)$value, $descendants)) {
                            $fail('A category cannot be its own descendant.');
                        }
                    }
                },
            ],
            'description' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
