<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Libraries\ImageUtil;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductImageController extends Controller
{

    public function index(Product $product): View
    {
        $productImages = $product->images()->paginate();

        return view('admin.product-images.index', compact('productImages', 'product'));
    }

    public function create(Product $product): View
    {
        return view('admin.product-images.create', compact('product'));
    }

    public function store(AddProductImageRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['path'] = ImageUtil::save($request->file('path'), 'images/products');
        
        $product->images()->create($data);

        return to_route('admin.product-images.index', $product->slug)->with('success', 'Product image uploaded successfully.');
    }

    public function show(ProductImage $productImage): never
    {
        abort(404);
    }

    public function edit(ProductImage $productImage): View
    {
        return view('admin.product-images.edit', compact('productImage'));
    }

    public function update(UpdateProductImageRequest $request, ProductImage $productImage): RedirectResponse
    {
        $productImage->update($request->validated());

        return to_route('admin.product-images.index', $productImage->product->slug)->with('success', 'Product image updated successfully.');
    }

    public function destroy(ProductImage $productImage): RedirectResponse
    {
        $productImage->delete();

        return to_route('admin.product-images.index', $productImage->product->slug)->with('success', 'Product image deleted successfully.');
    }

}
