@extends('admin.layouts.app')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Product Images ({{ $product->name }})</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product Images</li>
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
                @session('success')
                <div class="callout callout-success mb-4">
                    <h5 class="fw-bold">Success</h5>
                    <p>
                        {{ session('success') }}
                    </p>
                </div>
                @endsession
                <div class="card mb-4">
                    <div class="card-header">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('admin.product-images.create', $product->slug) }}" class="btn btn-primary">
                                    <i class="bi bi-plus-lg"></i>
                                    Upload Product Image
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Alternative Text</th>
                                <th scope="col">Thumb</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($productImages as $productImage)
                                <tr class="align-middle">
                                    <td><img src="{{ $productImage->path }}" class="imag-fluid rounded" width="64" height="64"/></td>
                                    <td>{{ $productImage->alt }}</td>
                                    <td>
                                        @if($productImage->is_thumb)
                                            <span class="badge text-bg-success">Thumb</span>
                                        @else
                                            <span class="badge text-bg-danger">Not Thumb</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.product-images.edit', $productImage) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.product-images.destroy', $productImage) }}" method="post" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No images found.</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex justify-content-end align-items-center w-100">
                        {{ $productImages->links() }}
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
