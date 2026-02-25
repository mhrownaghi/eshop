@extends('admin.layouts.app')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Related Products ({{ $product->name }})</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Related Products</li>
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
                                <a href="{{ route('admin.product-relations.create', $product->slug) }}" class="btn btn-primary">
                                    <i class="bi bi-plus-lg"></i>
                                    New Product Relation
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Related Product</th>
                                <th scope="col">Type</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($relatedProducts as $relatedProduct)
                                <tr class="align-middle">
                                    <td>{{ $relatedProduct->name }}</td>
                                    <td>
                                        {{ $relatedProduct->relation_type }}
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No related products found.</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
