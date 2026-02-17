<?php

namespace App\View\Components;

use App\Models\ProductCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCategoriesSelect extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $productCategories = ProductCategory::all(['name', 'slug']);
        $active = request('category', '');
        return view('components.product-categories-select', compact('productCategories', 'active'));
    }
}
