@extends('admin.layouts.app')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Product Categories</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product Categories</li>
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
                                <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-lg"></i>
                                    New Product Category
                                </a>
                                @if(request()->query('search'))
                                    <a href="{{ route('admin.product-categories.index') }}" class="btn btn-light">Clear Search</a>
                                @endif
                            </div>
                            <form action="{{ route('admin.product-categories.index') }}" method="get">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request()->search }}">
                                    <button class="btn btn-primary" type="submit">
                                        Search
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Parent</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($productCategories as $productCategory)
                                <tr class="align-middle">
                                    <td>{{ $productCategory->name }}</td>
                                    <td>{{ $productCategory->slug }}</td>
                                    <td>
                                        @if($productCategory->parent)
                                            {{ $productCategory->parent->name }}
                                        @else
                                            None
                                        @endif
                                    </td>
                                    <td>
                                        @if($productCategory->is_active)
                                            <span class="badge text-bg-success">Active</span>
                                        @else
                                            <span class="badge text-bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.product-categories.edit', $productCategory) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.product-categories.destroy', $productCategory) }}" method="post" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No product categories found.</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex justify-content-end align-items-center w-100">
                        {{ $productCategories->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
