<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\IndexProductCategoryRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexProductCategoryRequest $request): View
    {
        $data = $request->validated();

        $products = Product::with(['category'])
            ->when($data['search'] ?? null, function ($query, $search) {
                $escapedSearch = str_replace(['%', '_'], ['\\%', '\\_'], $search);
                $query->where('name', 'like', '%' . $escapedSearch . '%');
            })
            ->when($data['category'] ?? null, function ($query, $category) {
                $categoryId = ProductCategory::select('id')->firstWhere('slug', $category)?->id;
                $query->where('category_id', $categoryId ?? 0);
            })
            ->orderBy('name')
            ->paginate()
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = ProductCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddProductRequest $request): RedirectResponse
    {
        try {
            Product::create($request->validated());
            return to_route('admin.products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create product: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e
            ]);
            return back()->with('error', 'Failed to create product category. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): never
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = ProductCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        try {
            $product->update($request->validated());

            return to_route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update product: ' . $e->getMessage(), [
                'id' => $product->id,
                'exception' => $e
            ]);

            return back()->with('error', 'Failed to update product. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return to_route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
    
}
