<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">

        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ get_settings('system_logo_white') ? asset(get_settings('system_logo_white')) : asset('pictures/default-logo-white.png') }}"
                alt="App Logo" class="brand-image">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Request::is('admin/dashboard') ? ' active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <!-- Categories -->
                <li class="nav-item {{ Request::segment(2) == 'categories' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(2) == 'categories' ? ' active' : '' }}">
                        <i class="nav-icon bi bi-columns-gap"></i>
                        <p>
                            Categories
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('admin.category.index') }}"
                                class="nav-link {{ Request::is('admin/categories') ? ' active' : '' }}"> <i
                                    class="nav-icon bi bi-bookmark-star-fill"></i>
                                <p>Primary Categories</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{ route('admin.category.index.sub') }}"
                                class="nav-link {{ Request::is('admin/categories/sub') ? ' active' : '' }}"> <i
                                    class="nav-icon bi bi-bookmarks-fill"></i>
                                <p>Sub Categories</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{ route('admin.category.add') }}"
                                class="nav-link {{ Request::is('admin/categories/add') ? ' active' : '' }}"> <i
                                    class="nav-icon bi bi-plus-circle"></i>
                                <p>Add Category</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{ route('admin.category.sub.add') }}"
                                class="nav-link {{ Request::is('admin/categories/sub/add') ? ' active' : '' }}"> <i
                                    class="nav-icon bi bi-plus-circle"></i>
                                <p>Add Sub Category</p>
                            </a>
                        </li>

                    </ul>

                </li>

                <!-- Specification Keys -->
                <li class="nav-item {{ Request::segment(3) == 'specification' ? 'menu-open' : '' }}">
                    <a href="javascript:;" class="nav-link {{ Request::segment(3) == 'specification' ? ' active' : '' }}">
                        <i class="nav-icon bi bi-gear-wide-connected"></i>
                        <p>
                            Specification Keys
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> 
                            <a href="{{ route('admin.category.specification.key.public') }}" class="nav-link {{ Request::is('admin/categories/specification/keys/public') ? ' active' : '' }}">
                                <i class="nav-icon bi bi-command"></i>
                                <p>Public Keys</p>
                            </a>
                        <li class="nav-item"> <a href="{{ route('admin.category.specification.key.index') }}"
                                class="nav-link {{ Request::is('admin/categories/specification/keys') ? ' active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Keys</p>
                            </a>
                        </li>
                </li>
                <li class="nav-item"> <a href="{{ route('admin.category.specification.type.index') }}"
                        class="nav-link {{ Request::is('admin/categories/specification/types') ? ' active' : '' }}">
                        <i class="nav-icon bi bi-plus-circle"></i>
                        <p>Key Types</p>
                    </a>
                </li>
                <li class="nav-item"> <a href="{{ route('admin.category.specification.type.attribute.index') }}"
                        class="nav-link {{ Request::is('admin/categories/specification/types/attributes') ? ' active' : '' }}">
                        <i class="nav-icon bi bi-plus-circle"></i>
                        <p>Type attributes</p>
                    </a>
                </li>
            </ul>
            </li>

            <!-- Product -->
            <li
                class="nav-item {{ Request::is('admin/product*') || Request::is('admin/banner*') || Request::is('admin/flash-deal*') || Request::is('admin/stock*') || Request::is('admin/coupon*') ? 'menu-open' : '' }}">
                <a href="javascript:;" class="nav-link">
                    <i class="nav-icon bi bi-cart2"></i>
                    <p>
                        Products
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.product.create') }}"
                            class="nav-link {{ Request::is('admin/products/create') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-bag-plus"></i>
                            <p>Add New Product</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.product.index') }}"
                            class="nav-link {{ Request::is('admin/product') || Request::is('admin/product/*') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-shop-window"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.product.specification.edit') }}"
                            class="nav-link {{ Request::is('admin/products/specifications/*') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-layers"></i>
                            <p>Specification Controls</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.stock.index') }}"
                            class="nav-link {{ Request::is('admin/stock') || Request::is('admin/stock/*') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-archive"></i>
                            <p>Stock</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.flash-deal.index') }}"
                            class="nav-link {{ Request::is('admin/flash-deal*') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-amd"></i>
                            <p>Flash Deals</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.banner.index') }}"
                            class="nav-link {{ Request::is('admin/banner') || Request::is('admin/banner/*') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-images"></i>
                            <p>Banner</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.coupon.index') }}"
                            class="nav-link {{ Request::is('admin/coupon') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-images"></i>
                            <p>Coupon</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Bulk Import -->
            <li class="nav-item {{ Request::is('admin/import*') ? 'menu-open' : '' }}">
                <a href="javascript:;" class="nav-link">
                    <i class="nav-icon bi bi-cloud-upload"></i>
                    <p>
                        Bulk Import
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.import.category') }}"
                            class="nav-link {{ Request::is('admin/import/category') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-basket2-fill"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.import.brand') }}"
                            class="nav-link {{ Request::is('admin/import/brand') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-arrow-clockwise"></i>
                            <p>Brands</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.import.product') }}"
                            class="nav-link {{ Request::is('admin/import/product') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-box2"></i>
                            <p>Products</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Order -->
            <li class="nav-item {{ Request::is('admin/orders*') ? 'menu-open' : '' }}">
                <a href="javascript:;" class="nav-link">
                    <i class="nav-icon bi bi-basket2-fill"></i>
                    <p>
                        Orders
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.order.index') }}"
                            class="nav-link {{ Request::is('admin/orders') && Request::get('status') == null && Request::get('refund_requested') == null ? ' active' : '' }}">
                            <i class="nav-icon bi bi-basket2-fill"></i>
                            <p>All Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.order.index', ['status' => 'pending']) }}"
                            class="nav-link {{ Request::is('admin/orders') && Request::get('status') == 'pending' ? ' active' : '' }}">
                            <i class="nav-icon bi bi-arrow-clockwise"></i>
                            <p>Pending Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.order.index', ['status' => 'packaging']) }}"
                            class="nav-link {{ Request::is('admin/orders') && Request::get('status') == 'packaging' ? ' active' : '' }}">
                            <i class="nav-icon bi bi-box2"></i>
                            <p>Packaging Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.order.index', ['status' => 'shipping']) }}"
                            class="nav-link {{ Request::is('admin/orders') && Request::get('status') == 'shipping' ? ' active' : '' }}">
                            <i class="nav-icon bi bi-rocket-takeoff"></i>
                            <p>Shipping Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.order.index', ['status' => 'out_of_delivery']) }}"
                            class="nav-link {{ Request::is('admin/orders') && Request::get('status') == 'out_of_delivery' ? ' active' : '' }}">
                            <i class="nav-icon bi bi-truck"></i>
                            <p>Out for Delivery Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.order.index', ['status' => 'delivered']) }}"
                            class="nav-link {{ Request::is('admin/orders') && Request::get('status') == 'delivered' ? ' active' : '' }}">
                            <i class="nav-icon bi bi-check-square"></i>
                            <p>Delivered Orders</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.order.index', ['status' => 'returned']) }}"
                            class="nav-link {{ Request::is('admin/orders') && Request::get('status') == 'returned' ? ' active' : '' }}">
                            <i class="nav-icon bi bi-arrow-return-left"></i>
                            <p>Returned Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.order.index', ['status' => 'failed']) }}"
                            class="nav-link {{ Request::is('admin/orders') && Request::get('status') == 'failed' ? ' active' : '' }}">
                            <i class="nav-icon bi bi-slash-square"></i>
                            <p>Failed Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.order.index', ['status' => 'refund_requested']) }}"
                            class="nav-link {{ Request::is('admin/orders') && Request::get('refund_requested') != null ? ' active' : '' }}">
                            <i class="nav-icon bi bi-credit-card-2-front"></i>
                            <p>Refund Requested Orders</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Customer -->
            <li class="nav-item {{ Request::is('admin/customer*') ? 'menu-open' : '' }}">
                <a href="javascript:;" class="nav-link">
                    <i class="nav-icon bi bi-people"></i>
                    <p>
                        Customers
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.customer.index') }}"
                            class="nav-link {{ Request::is('admin/customer') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-person-bounding-box"></i>
                            <p>All Customers</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.customer.question.index') }}"
                            class="nav-link {{ Request::is('admin/customer/question') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-patch-question"></i>
                            <p>Questions</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Brands -->
            <li
                class="nav-item {{ Request::is('admin/brand*') || Request::is('admin/brand-type') ? 'menu-open' : '' }}">
                <a href="javascript:;" class="nav-link">
                    <i class="nav-icon bi bi-ubuntu"></i>
                    <p>
                        Brands
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.brand.index') }}"
                            class="nav-link {{ Request::is('admin/brand') || Request::is('admin/brand/*') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-unity"></i>
                            <p>Brand</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.brand-type.index') }}"
                            class="nav-link {{ Request::is('admin/brand-type') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-strava"></i>
                            <p>Brand Types</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Website Setup -->
            <li class="nav-item {{ Request::is('admin/website*') || Request::is('admin/page*') ? 'menu-open' : '' }}">
                <a href="javascript:;" class="nav-link">
                    <i class="nav-icon bi bi-globe"></i>
                    <p>
                        Website Setup
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    {{-- <li class="nav-item">
                        <a href="{{ route('admin.website.header') }}"
                            class="nav-link {{ Request::is('admin/website/header') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-window-fullscreen"></i>
                            <p>Header</p>
                        </a>
                    </li> --}}

                    <li class="nav-item">
                        <a href="{{ route('admin.website.footer') }}"
                            class="nav-link {{ Request::is('admin/website/footer') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-window-desktop"></i>
                            <p>Footer</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.page.index') }}"
                            class="nav-link {{ Request::is('admin/page*') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-window-stack"></i>
                            <p>Pages</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.website.appearance') }}"
                            class="nav-link {{ Request::is('admin/website/appearance') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-window-split"></i>
                            <p>Appearance</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Setup & Configuration -->
            <li
                class="nav-item {{ Request::is('admin/settings/*') || Request::is('admin/currency') || Request::is('admin/homepage/*') || Request::is('admin/tax') ? 'menu-open' : '' }}">
                <a href="javascript:;" class="nav-link">
                    <i class="nav-icon bi bi-gear"></i>
                    <p>
                        Settings
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.general') }}"
                            class="nav-link {{ Request::is('admin/settings/general') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-gear"></i>
                            <p>General Settings</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.homepage.settings') }}"
                            class="nav-link {{ Request::is('admin/homepage/*') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-house-gear"></i>
                            <p>Homepage Settings</p>
                        </a>
                    </li>

                    {{-- <li class="nav-item"> 
                            <a href="{{ route('admin.settings') }}" class="nav-link {{ Request::is('admin/roles') ? ' active' : '' }}"> 
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Language</p>
                            </a> 
                        </li> --}}

                    {{-- <li class="nav-item">
                        <a href="{{ route('admin.currency.index') }}"
                            class="nav-link {{ Request::is('admin/currency') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-currency-exchange"></i>
                            <p>Currency</p>
                        </a>
                    </li> --}}

                    <li class="nav-item">
                        <a href="{{ route('admin.tax.index') }}"
                            class="nav-link {{ Request::is('admin/tax') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-piggy-bank-fill"></i>
                            <p>VAT & Tax</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.settings.otp') }}"
                            class="nav-link {{ Request::is('admin/settings/otp') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-envelope-paper-fill"></i>
                            <p>OTP Templates</p>
                        </a>
                    </li>

                </ul>
            </li>

            <!-- Shipping Configuration -->
            <li
                class="nav-item {{ Request::is('admin/zone') || Request::is('admin/city') || Request::is('admin/country') ? 'menu-open' : '' }}">
                <a href="javascript:;" class="nav-link ">
                    <i class="nav-icon bi bi-truck"></i>
                    <p>
                        Shipping
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link {{ Request::is('admin/stuff') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-sliders"></i>
                            <p>Shipping Configuration</p>
                        </a>
                    </li>

                    {{-- @if (Auth::guard('admin')->user()->hasPermissionTo('zone.view')) --}}
                    {{-- <li class="nav-item">
                        <a href="{{ route('admin.zone.index') }}"
                            class="nav-link {{ Request::is('admin/zone') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-radar"></i>
                            <p>Zones</p>
                        </a>
                    </li> --}}
                    {{-- @endif --}}

                    {{-- @if (Auth::guard('admin')->user()->hasPermissionTo('country.view')) --}}
                    {{-- <li class="nav-item">
                        <a href="{{ route('admin.country.index') }}"
                            class="nav-link {{ Request::is('admin/country') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-map"></i>
                            <p>Countries</p>
                        </a>
                    </li> --}}
                    {{-- @endif --}}

                    {{-- @if (Auth::guard('admin')->user()->hasPermissionTo('city.view')) --}}
                    {{-- <li class="nav-item">
                        <a href="{{ route('admin.city.index') }}"
                            class="nav-link {{ Request::is('admin/city') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-pin-map"></i>
                            <p>Cities</p>
                        </a>
                    </li> --}}
                    {{-- @endif --}}
                </ul>
            </li>

            <!-- Staff & Permission -->
            <li class="nav-item {{ Request::is('admin/stuff*') || Request::is('admin/roles*') ? 'menu-open' : '' }}">
                <a href="javascript:;" class="nav-link">
                    <i class="nav-icon bi bi-people"></i>
                    <p>
                        Staffs
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    {{-- @if (Auth::guard('admin')->user()->hasPermissionTo('stuff.view')) --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.stuff.index') }}"
                            class="nav-link {{ Request::is('admin/stuff*') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>All Staffs</p>
                        </a>
                    </li>
                    {{-- @endif --}}

                    {{-- @if (Auth::guard('admin')->user()->hasPermissionTo('roles.view')) --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}"
                            class="nav-link {{ Request::is('admin/roles*') ? ' active' : '' }}">
                            <i class="nav-icon bi bi-person-gear"></i>
                            <p>Staff Permission</p>
                        </a>
                    </li>
                    {{-- @endif --}}
                </ul>
            </li>

            <!-- System -->
            {{-- @if (Auth::guard('admin')->user()->hasPermissionTo('test-model.view')) --}}
            <li class="nav-item">
                <a href="{{ route('admin.system_server') }}"
                    class="nav-link {{ Request::is('admin/server-status') ? ' active' : '' }}">
                    <i class="nav-icon bi bi-hdd"></i>
                    <p>
                        System
                    </p>
                </a>
            </li>
            {{-- @endif --}}

            <!-- Bulk Image Upload -->
            <li class="nav-item">
                <a href="{{ route('admin.image.index') }}"
                    class="nav-link {{ Request::is('admin/image-upload') ? ' active' : '' }}">
                    <i class="nav-icon bi bi-cloud-upload"></i>
                    <p>
                        Image Upload
                    </p>
                </a>
            </li>

            </ul>
        </nav>
    </div>
</aside>
