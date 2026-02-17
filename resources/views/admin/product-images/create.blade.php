@extends('admin.layouts.app')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Upload Product Image ({{ $product->name }})</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.product-images.index', $product->slug) }}">Product Images</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Upload Product Image</li>
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
                        Product Image Settings
                    </div>
                    <form action="{{ route('admin.product-images.store', $product->slug) }}" method="POST" enctype="multipart/form-data">
                        <!-- /.card-header -->
                        <div class="card-body">
                            @csrf
                            <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                <div style="width: 120px">
                                    <label for="path" class="col-form-label">
                                        Image
                                        <span class="text-danger fs-5">*</span>
                                    </label>
                                </div>
                                <div>
                                    <input
                                        type="file"
                                        class="form-control @error('file') is-invalid @enderror"
                                        id="path"
                                        name="path"
                                        value="{{ old('path') }}"
                                        aria-describedby="pathFeedback">
                                </div>
                                @error('path')
                                <div id="pathFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="is-thumb"
                                       name="is_thumb" @checked(old('is_thumb'))>
                                <label class="form-check-label" for="is-active">Thumb</label>
                            </div>
                            <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                <div style="width: 120px">
                                    <label for="alt" class="col-form-label">
                                        Alternative Text
                                        <span class="text-danger fs-5">*</span>
                                    </label>
                                </div>
                                <div>
                                    <input
                                        type="text"
                                        class="form-control @error('alt') is-invalid @enderror"
                                        id="alt"
                                        name="alt"
                                        value="{{ old('alt') }}"
                                        aria-describedby="altFeedback">
                                </div>
                                @error('alt')
                                <div id="altFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
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