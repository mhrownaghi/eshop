<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRelationController extends Controller
{
    public function index(Product $product)
    {
        $relatedProducts = $product->relatedProducts();

        return view('admin.product-relations.index', compact('product', 'relatedProducts'));
    }
}
