<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="../index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
                src="{{ asset('assets/img/AdminLTELogo.png') }}"
                alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">AdminLTE 4</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main navigation"
                data-accordion="false"
                id="navigation"
            >
                <li class="nav-header">E-Commerce</li>
                <li class="nav-item">
                    <a
                        href="{{ route('admin.product-categories.index') }}"
                        @class([
                            'nav-link',
                            'active' => url()->current() === route('admin.product-categories.index')
                        ])
                    >
                        <i class="nav-icon bi bi-grid"></i>
                        <p>Product Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('admin.products.index') }}"
                        @class([
                            'nav-link',
                            'active' => url()->current() === route('admin.products.index')
                        ])
                    >
                        <i class="nav-icon bi bi-grid"></i>
                        <p>Products</p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
