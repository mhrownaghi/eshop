@extends('admin.layouts.app')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit Product</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                @session('error')
                    <div class="callout callout-danger mb-4">
                        <h5 class="fw-bold">Error</h5>
                        <p>
                            {{ session('error') }}
                        </p>
                    </div>
                @endsession
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        Product Specification
                    </div>
                    <form action="{{ route('admin.products.update', $product->slug) }}" method="POST">
                        <div class="card-body">
                            @csrf
                            @method('PUT')
                            @php
                                $tabErrors = [
                                    'general' => $errors->hasAny(['name', 'category_id']),
                                    'technical' => $errors->hasAny(['height', 'volume', 'diagonal', 'weight', 'box']),
                                    'price' => $errors->hasAny(['price', 'old_price', 'additional_price']),
                                    'accounting' => $errors->hasAny(['stock', 'sku']),
                                    'settings' => $errors->hasAny(['type']),
                                ];

                                $activeTab = collect($tabErrors)->search(true) ?: 'general';
                            @endphp
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a
                                        @class([
                                            'nav-link',
                                            'active' => $activeTab == 'general',
                                            'text-danger' => $tabErrors['general'],
                                        ])
                                        data-bs-toggle="tab"
                                        data-bs-target="#tab-general"
                                        type="button" role="tab"
                                        aria-controls="tab-general"
                                        aria-selected="true">
                                        General
                                        @if($tabErrors['general']) <i class="bi bi-exclamation-triangle"></i> @endif
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        @class([
                                            'nav-link',
                                            'active' => $activeTab == 'technical',
                                            'text-danger' => $tabErrors['technical'],
                                        ])
                                        class="nav-link"
                                        data-bs-toggle="tab"
                                        data-bs-target="#tab-technical"
                                        type="button"
                                        role="tab"
                                        aria-controls="tab-technical"
                                        aria-selected="true">
                                        Technical
                                        @if($tabErrors['technical']) <i class="bi bi-exclamation-triangle"></i> @endif
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        @class([
                                            'nav-link',
                                            'active' => $activeTab == 'price',
                                            'text-danger' => $tabErrors['price'],
                                        ])
                                        class="nav-link"
                                        data-bs-toggle="tab"
                                        data-bs-target="#tab-price"
                                        type="button"
                                        role="tab"
                                        aria-controls="tab-price"
                                        aria-selected="true">
                                        Price
                                        @if($tabErrors['price']) <i class="bi bi-exclamation-triangle"></i> @endif
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        @class([
                                            'nav-link',
                                            'active' => $activeTab == 'accounting',
                                            'text-danger' => $tabErrors['accounting'],
                                        ])
                                        class="nav-link"
                                        data-bs-toggle="tab"
                                        data-bs-target="#tab-accounting"
                                        type="button"
                                        role="tab"
                                        aria-controls="tab-accounting"
                                        aria-selected="true">
                                        Accounting
                                        @if($tabErrors['accounting']) <i class="bi bi-exclamation-triangle"></i> @endif
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        @class([
                                            'nav-link',
                                            'active' => $activeTab == 'settings',
                                            'text-danger' => $tabErrors['settings'],
                                        ])
                                        class="nav-link"
                                        data-bs-toggle="tab"
                                        data-bs-target="#tab-settings"
                                        type="button"
                                        role="tab"
                                        aria-controls="tab-settings"
                                        aria-selected="true">
                                        Settings
                                        @if($tabErrors['settings']) <i class="bi bi-exclamations"></i> @endif
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content p-3 border-start border-end border-bottom">
                                <div
                                    @class([
                                        'tab-pane',
                                        'active' => $activeTab == 'general',
                                        'show' => $activeTab == 'general',
                                    ])
                                    id="tab-general"
                                    role="tabpanel">
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="name" class="col-form-label">
                                                Name
                                                <span class="text-danger fs-5">*</span>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $product->name) }}"
                                                aria-describedby="nameFeedback">
                                        </div>
                                        @error('name')
                                            <div id="nameFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="is-active"
                                            name="is_active" @checked(old('is_active', $product->is_active))>
                                        <label class="form-check-label" for="is-active">Is Active</label>
                                    </div>
                                    <div class="d-flex align-items-center column-gap-2 flex-wrap mb-3">
                                        <div style="width: 110px">
                                            <label for="category-id">Category</label>
                                        </div>
                                        <div>
                                            <select class="@error('category_id') is-invalid @enderror"
                                                id="category-id" name="category_id" aria-label="Category"
                                                aria-describedby="categoryFeedback">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @selected(old('category_id', $product->category_id) == $category->id)>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('category_id')
                                            <div id="categoryFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex column-gap-2 align-items-center flex-wrap mb-3">
                                        <div style="width: 110px">
                                            <label for="editor">Description</label>
                                        </div>
                                        <div>
                                            <textarea class="form-control" id="editor" name="description"
                                                rows="3">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex column-gap-2 align-items-center flex-wrap mb-3">
                                        <div style="width: 110px">
                                            <label for="short-description">Short Description</label>
                                        </div>
                                        <div>
                                            <textarea class="form-control" id="short-description" name="short_description"
                                                rows="3" cols="100">{{ old('short_description', $product->short_description) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex column-gap-2 align-items-center flex-wrap mb-3">
                                        <div style="width: 110px">
                                            <label for="meta-description">Meta Description</label>
                                        </div>
                                        <div>
                                            <textarea class="form-control" id="meta-description" name="meta_description"
                                                rows="3" cols="100">{{ old('meta_description', $product->meta_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    @class([
                                        'tab-pane',
                                        'active' => $activeTab == 'technical',
                                        'show' => $activeTab == 'technical',
                                    ])
                                    id="tab-technical"
                                    role="tabpanel">
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="height" class="col-form-label">Height</label>
                                        </div>
                                        <div class="input-group" style="width: unset">
                                            <input type="text" class="form-control @error('height') is-invalid @enderror"
                                                id="height" name="height" value="{{ old('height', $product->height) }}"
                                                aria-describedby="heightFeedback">
                                            <span class="input-group-text">cm</span>
                                        </div>
                                        @error('height')
                                            <div id="heightFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="diagonal" class="col-form-label">Diagonal</label>
                                        </div>
                                        <div class="input-group" style="width: unset">
                                            <input type="text" class="form-control @error('diagonal') is-invalid @enderror"
                                                id="diagonal" name="diagonal" value="{{ old('diagonal', $product->diagonal) }}"
                                                aria-describedby="diagonalFeedback">
                                            <span class="input-group-text">cm</span>
                                        </div>
                                        @error('diagonal')
                                            <div id="diagonalFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="volume" class="col-form-label">Volume</label>
                                        </div>
                                        <div class="input-group" style="width: unset">
                                            <input type="text" class="form-control @error('volume') is-invalid @enderror"
                                                id="volume" name="volume" value="{{ old('volume', $product->volume) }}"
                                                aria-describedby="volumeFeedback">
                                            <span class="input-group-text">ml</span>
                                        </div>
                                        @error('volume')
                                            <div id="volumeFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="volume" class="col-form-label">Weight(honey)</label>
                                        </div>
                                        <div class="input-group" style="width: unset">
                                            <input type="text" class="form-control @error('weight') is-invalid @enderror"
                                                id="weight" name="weight" value="{{ old('weight',$product->weight) }}"
                                                aria-describedby="weightFeedback">
                                            <span class="input-group-text">grams</span>
                                        </div>
                                        @error('weight')
                                            <div id="weightFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="box" class="col-form-label">Box</label>
                                        </div>
                                        <div>
                                            <input type="text" class="form-control @error('box') is-invalid @enderror"
                                                id="box" name="box" value="{{ old('box', $product->box) }}" aria-describedby="boxFeedback">
                                        </div>
                                        @error('box')
                                            <div id="boxFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div
                                    @class([
                                        'tab-pane',
                                        'active' => $activeTab == 'price',
                                        'show' => $activeTab == 'price',
                                    ])
                                    id="tab-price"
                                    role="tabpanel">
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="price" class="col-form-label">Price</label>
                                        </div>
                                        <div>
                                            <input type="text" class="form-control @error('price') is-invalid @enderror"
                                                id="price" name="price" value="{{ old('price', $product->price) }}"
                                                aria-describedby="priceFeedback">
                                        </div>
                                        @error('price')
                                            <div id="priceFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="old-price" class="col-form-label">Old Price</label>
                                        </div>
                                        <div>
                                            <input type="text" class="form-control @error('old_price') is-invalid @enderror"
                                                id="old-price" name="old_price" value="{{ old('old_price', $product->old_price) }}"
                                                aria-describedby="old-priceFeedback">
                                        </div>
                                        @error('old_price')
                                            <div id="old-priceFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="additional-price" class="col-form-label">Additional Price</label>
                                        </div>
                                        <div>
                                            <input type="text" class="form-control @error('additional_price') is-invalid @enderror"
                                                id="additional-price" name="additional_price"
                                                value="{{ old('additional_price', $product->additional_price) }}"
                                                aria-describedby="additional-priceFeedback">
                                        </div>
                                        @error('additional_price')
                                            <div id="additional-priceFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="can-increase-price" name="can_increase_price"
                                            @checked(old('can_increase_price', $product->can_increase_price))>
                                        <label class="form-check-label" for="can-increase-price">Can Increase Price</label>
                                    </div>
                                </div>
                                <div
                                    @class([
                                        'tab-pane',
                                        'active' => $activeTab == 'accounting',
                                        'show' => $activeTab == 'accounting',
                                    ])
                                    id="tab-accounting"
                                    role="tabpanel">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="is-stock"
                                            name="is_stock" @checked(old('is_stock', $product->is_stock))>
                                        <label class="form-check-label" for="is-stock">Enable Stock</label>
                                    </div>
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="stock" class="col-form-label">Stock</label>
                                        </div>
                                        <div>
                                            <input type="text" class="form-control @error('stock') is-invalid @enderror"
                                                id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                                                aria-describedby="stockFeedback">
                                        </div>
                                        @error('stock')
                                            <div id="stockFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="sku" class="col-form-label">
                                                SKU
                                                <span class="text-danger fs-5">*</span>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                                id="sku" name="sku" value="{{ old('sku', $product->sku) }}" aria-describedby="skuFeedback">
                                        </div>
                                        @error('sku')
                                            <div id="skuFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div
                                    @class([
                                        'tab-pane',
                                        'active' => $activeTab == 'settings',
                                        'show' => $activeTab == 'settings',
                                    ])
                                    id="tab-settings"
                                    role="tabpanel">
                                    <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                        <div style="width: 110px">
                                            <label for="type" class="col-form-label">Type</label>
                                        </div>
                                        <div>
                                            <select class="form-select @error('type') is-invalid @enderror" id="type"
                                                name="type" aria-label="Type" aria-describedby="type-feedback">
                                                <option value="lid" @selected(old('type', $product->type) == 'lid')>
                                                    lid
                                                </option>
                                                <option value="box" @selected(old('type', $product->type) == 'box')>
                                                    box
                                                </option>
                                                <option value="other" @selected(old('type', $product->type) == 'other')>
                                                    other
                                                </option>
                                            </select>
                                        </div>
                                        @error('type')
                                            <div id="typeFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="has-selectable-lid" name="has_selectable_lid"
                                            @checked(old('has_selectable_lid', $product->has_selectable_lid))>
                                        <label class="form-check-label" for="has-selectable-lid">Has selectable lid</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="has-selectable-box" name="has_selectable_box"
                                            @checked(old('has_selectable_box', $product->has_selectable_box))>
                                        <label class="form-check-label" for="has-selectable-box">Has selectable box</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="offline-shopping"
                                            name="offline_shopping" @checked(old('offline_shopping', $product->offline_shopping))>
                                        <label class="form-check-label" for="offline-shopping">Offline Shopping</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end align-items-center w-100">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

@push('scripts')
    <script>
        new TomSelect("#category-id", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "{{ asset('assets/js/ckeditor5.js') }}"
            }
        }
    </script>
    <script type="module">

        import {
            ClassicEditor,
            Essentials,
            Bold,
            Italic,
            Paragraph,
            Font,
            Heading,
            Strikethrough,
            Subscript,
            Superscript,
            Code,
            Link,
            BlockQuote,
            CodeBlock,
            Alignment,
            List,
            Indent,
            Image
        } from 'ckeditor5';

        ClassicEditor
            .create(document.querySelector('#editor'), {
                licenseKey: 'GPL',
                plugins: [Essentials, Bold, Italic, Font, Paragraph, Heading, Strikethrough, Subscript, Superscript, Code, Link, BlockQuote, CodeBlock, Alignment, List, Indent],
                toolbar: {
                    items: [
                        'undo', 'redo',
                        '|',
                        'heading',
                        '|',
                        'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                        '|',
                        'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
                        '|',
                        'link', 'blockQuote', 'codeBlock',
                        '|',
                        'alignment',
                        '|',
                        'bulletedList', 'numberedList', 'outdent', 'indent'
                    ],
                    shouldNotGroupWhenFull: true
                },
                menuBar: {
                    isVisible: true
                }
            })
    </script>
@endpush