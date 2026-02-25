<?php

use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductRelationController;
use App\Models\ProductRelation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function (){
    Route::resource('product-categories', ProductCategoryController::class,[
        'names' => [
            'index' => 'admin.product-categories.index',
            'create' => 'admin.product-categories.create',
            'store' => 'admin.product-categories.store',
            'edit' => 'admin.product-categories.edit',
            'update' => 'admin.product-categories.update',
            'destroy' => 'admin.product-categories.destroy',
        ],
    ]);
    Route::resource('products', ProductController::class,[
        'names' => [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ],
    ]);
    Route::controller(ProductImageController::class)->group(function () {
        Route::get('product-images/{product}', 'index')->name('admin.product-images.index');
        Route::get('product-images/{product}/create', 'create')->name('admin.product-images.create');
        Route::post('product-images/{product}', 'store')->name('admin.product-images.store');
        Route::get('product-images/{product_image}', 'show')->name('admin.product-images.show');
        Route::get('product-images/{product_image}/edit', 'edit')->name('admin.product-images.edit');
        Route::put('product-images/{product_image}', 'update')->name('admin.product-images.update');
        Route::delete('product-images/{product_image}', 'destroy')->name('admin.product-images.destroy');
    });

    Route::controller(ProductRelationController::class)->group(function () {
        Route::get('products/{product}/related-products', 'index')->name('admin.product-relations.index');
        Route::get('product-relations/{product}/create', 'create')->name('admin.product-relations.create');
        Route::post('product-relations/{product}', 'store')->name('admin.product-relations.store');
        Route::delete('product-relations/{product_relation}', 'destroy')->name('admin.product-relations.destroy');
    });
});
