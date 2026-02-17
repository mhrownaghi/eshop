@extends('admin.layouts.app')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Create Product Category</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.product-categories.index') }}">Product Categories</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Product Category</li>
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
                        Product Category Specification
                    </div>
                    <form action="{{ route('admin.product-categories.store') }}" method="POST">
                        <!-- /.card-header -->
                        <div class="card-body">
                            @csrf
                            <div class="d-flex column-gap-2 flex-wrap mb-3 align-items-center">
                                <div style="width: 110px">
                                    <label for="name" class="col-form-label">Name</label>
                                </div>
                                <div>
                                    <input
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
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
                                       name="is_active" @checked(old('is_active'))>
                                <label class="form-check-label" for="is-active">Is Active</label>
                            </div>
                            <div class="d-flex align-items-center column-gap-2 flex-wrap mb-3">
                                <div style="width: 110px">
                                    <label for="parent-id">Parent Category</label>
                                </div>
                                <div>
                                    <select
                                        class="@error('parent_id') is-invalid @enderror"
                                        id="parent-id"
                                        name="parent_id"
                                        aria-label="Parent Category"
                                        aria-describedby="parent-feedback">
                                        <option value="">None</option>
                                        @foreach ($productCategories as $productCategory)
                                            <option
                                                value="{{ $productCategory->id }}"
                                                @selected(old('parent_id') == $productCategory->id)>
                                                {{ $productCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('parent_id')
                                    <div id="parent-feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-flex column-gap-2 align-items-center flex-wrap mb-3">
                                <div style="width: 110px">
                                    <label for="editor">Description</label>
                                </div>
                                <div>
                                    <textarea
                                        class="form-control"
                                        id="editor"
                                        name="description"
                                        rows="3">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="d-flex column-gap-2 align-items-center flex-wrap mb-3">
                                <div style="width: 110px">
                                    <label for="meta-description">Meta Description</label>
                                </div>
                                <div>
                                    <textarea
                                        class="form-control"
                                        id="meta-description"
                                        name="meta_description"
                                        rows="3"
                                        cols="100">{{ old('meta_description') }}</textarea>
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
        new TomSelect("#parent-id", {
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
