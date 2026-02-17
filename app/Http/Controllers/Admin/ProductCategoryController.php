<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductCategoryRequest;
use App\Http\Requests\IndexProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexProductCategoryRequest $request): View
    {
        $data = $request->validated();

        $productCategories = ProductCategory::query()
            ->when($data['search'] ?? null, function ($query, $search) {
                $escapedSearch = str_replace(['%', '_'], ['\\%', '\\_'], $search);
                $query->where('name', 'like', '%' . $escapedSearch . '%');
            })
            ->when($data['parent_id'] ?? null, function ($query, $parentId) {
                $query->where('parent_id', $parentId);
            })
            ->with('parent')
            ->orderBy('name')
            ->paginate()
            ->withQueryString();

        return view('admin.product-categories.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $productCategories = ProductCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.product-categories.create', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddProductCategoryRequest $request): RedirectResponse
    {
        try {
            ProductCategory::create($request->validated());
            return to_route('admin.product-categories.index')
                ->with('success', 'Product category created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create product category: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e
            ]);
            return back()->with('error', 'Failed to create product category. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory): never
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(ProductCategory $productCategory): View
    {
        $descendants = $productCategory->getAllDescendantIds();
        $excludeIds = array_merge([$productCategory->id], $descendants);

        $productCategories = ProductCategory::query()
            ->select('id', 'name')
            ->whereNotIn('id', $excludeIds)
            ->orderBy('name')
            ->get();

        return view(
            'admin.product-categories.edit',
            compact('productCategory', 'productCategories')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory): RedirectResponse
    {
        try {
            $productCategory->update($request->validated());

            return to_route('admin.product-categories.index')
                ->with('success', 'Product category updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update product category: ' . $e->getMessage(), [
                'id' => $productCategory->id,
                'exception' => $e
            ]);

            return back()->with('error', 'Failed to update product category. Please try again.');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->delete();
        return to_route('admin.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }
}
