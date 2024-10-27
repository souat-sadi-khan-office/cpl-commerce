<div class="bottom_header dark_skin main_menu_uppercase border-top border-bottom">
    <div class="custom-container">
        <div class="row align-items-center"> 
            <div class="col-lg-3 col-md-4 col-sm-6 col-3">
                <div class="categories_wrap">
                    <button type="button" data-bs-toggle="collapse" data-bs-target="#navCatContent" aria-expanded="false" class="categories_btn categories_menu">
                        <span>All Categories </span>
                        <i class="linearicons-menu"></i>
                    </button>
                    <div id="navCatContent" class="{{ Request::is('/') ? 'nav_cat' : '' }} navbar nav collapse">
                        <ul>
                            @foreach ($main_categories as $main_category)
                                <li class="{{ $main_category->children->isNotEmpty() ? 'dropdown dropdown-mega-menu' : '' }}">
                                    @if ($main_category->children->isNotEmpty())
                                        <a class="nav-link dropdown-item dropdown-toggler" href="{{ route('slug.handle', $main_category->slug) }}" data-bs-toggle="dropdown">
                                            {!! $main_category->icon !!}
                                            <span>{{ $main_category->name }}</span>
                                        </a>
                                    @else
                                        <a class="nav-link" href="{{ route('slug.handle', $main_category->slug) }}">
                                            {!! $main_category->icon !!}
                                            <span>{{ $main_category->name }}</span>
                                        </a>
                                    @endif
                                    
                                    @if($main_category->children->isNotEmpty())
                                    <div class="dropdown-menu">
                                        <ul>
                                            <li class="dropdown-header">{{ $main_category->name }}</li>
                                            @foreach($main_category->children as $child_category)
                                                <li>
                                                    <a class="dropdown-item nav-link nav_item" href="{{ route('slug.handle', $child_category->slug) }}">
                                                        {{ $child_category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </li>
                            @endforeach
                            <li class="dropdown dropdown-mega-menu">
                                <a class="dropdown-item nav-link dropdown-toggler" href="#" data-bs-toggle="dropdown"><i class="flaticon-plugins"></i> <span>Accessories</span></a>
                                <div class="dropdown-menu">
                                    <ul class="mega-menu d-lg-flex">
                                        <li class="mega-menu-col col-lg-4">
                                            <ul> 
                                                <li class="dropdown-header">Woman's</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.html">Vestibulum sed</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-left-sidebar.html">Donec porttitor</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-right-sidebar.html">Donec vitae facilisis</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-list.html">Curabitur tempus</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-load-more.html">Vivamus in tortor</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-col col-lg-4">
                                            <ul>
                                                <li class="dropdown-header">Men's</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-cart.html">Donec vitae ante ante</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="checkout.html">Etiam ac rutrum</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="wishlist.html">Quisque condimentum</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="compare.html">Curabitur laoreet</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="order-completed.html">Vivamus in tortor</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-col col-lg-4">
                                            <ul>
                                                <li class="dropdown-header">Kid's</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Donec vitae facilisis</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Quisque condimentum</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Etiam ac rutrum</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec vitae ante ante</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec porttitor</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <a href="{{ route('categories') }}" class="more_categories">
                            All Categories
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-6 col-9">
                <nav class="navbar navbar-expand-lg">
                    <button class="navbar-toggler side_navbar_toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSidetoggle" aria-expanded="false"> 
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                        <ul class="navbar-nav">
                            @php
                                $pages = App\Models\Page::with('children')->where('status', 1)->where('show_on_navbar', 1)->whereNull('parent_id')->get();
                            @endphp
                            @foreach ($pages as $page)
                                <li class="dropdown">
                                    
                                    @if ($page->children->isNotEmpty())
                                        <a data-bs-toggle="dropdown" class="nav-link dropdown-toggle" href="{{ route('slug.handle', $page->slug) }}">
                                            {{ $page->title }}
                                        </a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                @foreach ($page->children as $child)
                                                    @include('frontend.components.dropdown', ['page' => $child])
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <a class="nav-link" href="{{ route('slug.handle', $page->slug) }}">
                                            {{ $page->title }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                            <li>
                                <a class="nav-link nav_item" href="contact.html">
                                    Contact Us
                                </a>
                            </li>
                        </ul>
                    </div>
                    <ul class="navbar-nav attr-nav align-items-center">
                        <li>
                            <a href="javascript:;" class="nav-link pr_search_trigger">
                                <i class="linearicons-magnifier"></i>
                            </a>
                        </li>
                        <li class="dropdown cart_dropdown">
                            <a class="nav-link cart_trigger" href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="linearicons-cart"></i>
                                <span class="cart_count">0</span>
                            </a>
                            <div class="cart_box dropdown-menu dropdown-menu-right">
                                <i class="cart-loader fas fa-spinner fa-spin fa-4x"></i>
                                <ul class="cart_list mobile_cart_list scrollbar"></ul>
                                <div style="display: none;" class="cart_footer">
                                    <p class="cart_total">
                                        <strong>Subtotal:</strong> 
                                        <span class="cart_price"> 
                                            <span class="price_symbole">
                                                $
                                            </span>
                                        </span>
                                        <span class="cart_total_price">0.00</span>
                                    </p>
                                    <p class="cart_buttons">
                                        <a href="#" class="btn btn-fill-line view-cart">
                                            View Cart
                                        </a>
                                        <a href="#" class="btn btn-fill-out checkout">
                                            Checkout
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="pc-build-guide">
                        <a href="{{ route('laptop-buying-guide') }}" class="btn btn-sm btn-fill-out rounded py-2">
                            <i class="fas fa-laptop"></i>
                            Laptop Buying Guide
                        </a>
                        <a href="{{ route('pc-builder') }}" class="btn btn-sm btn-fill-out rounded py-2">
                            <i class="fas fa-desktop"></i>
                            PC Builder
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>