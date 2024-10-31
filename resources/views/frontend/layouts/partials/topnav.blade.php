<div class="middle-header dark_skin r">
    <div class="custom-container">
        <div class="nav_block">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img class="logo_light" src="{{ get_settings('system_logo_white') ? asset(get_settings('system_logo_white')) : asset('pictures/default-logo-white.png') }}" alt="System white logo">
                <img class="logo_dark" src="{{ get_settings('system_logo_dark') ? asset(get_settings('system_logo_dark')) : asset('pictures/default-logo-dark.png') }}" alt="System dark logo">
            </a>
            <div class="order-md-2">
                
            </div>
            <div class="product_search_form order-md-3">
                <form action="{{ route('search') }}" method="GET">
                    <div class="input-group">
                        <input class="form-control" autocomplete="off" placeholder="Search" required id="search" name="search" type="text">
                        <button type="submit" class="search_btn">
                            <i class="linearicons-magnifier"></i>
                        </button>
                    </div>
                </form>
                <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">
                    <div class="searching-preloader">
                        <div class="search-preloader">
                            <div class="lds-ellipsis">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="search-nothing d-none p-3 text-center fs-16">
                        
                    </div>
                    <div id="search-content" class="text-left">
                        <div class="">
                            
                        </div>
                        <div class="">
                            
                        </div>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav attr-nav align-items-center order-md-5">
                <li id="wishList">
                    <div class="q-actions">
                        <div class="ac">
                            <a class="ic" href="{{ route('account.wishlist') }}">
                                <i class="far fa-heart"></i>
                            </a>
                            <div class="ac-content">
                                <a href="{{ route('account.wishlist') }}">
                                    <h5>Wishlist</h5>
                                </a>
                                <p>
                                    <a id="wish_list_counter" href="{{ route('account.wishlist') }}">
                                        @if (!Auth::guard('customer')->check())
                                            0
                                        @else
                                            {{ App\Models\WishList::where('user_id', Auth::guard('customer')->user()->id)->count() }}
                                        @endif
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                <li id="accountLogin">
                    <div class="q-actions">
                        <div class="ac">
                            <a class="ic" href="{{ route('login') }}">
                                <i class="far fa-user"></i>
                            </a>
                            <div class="ac-content">
                                <a href="{{ route('login') }}">
                                    <h5>Account</h5>
                                </a>
                                <p>
                                    @if (Auth::guard('customer')->check())
                                        <a href="{{ route('dashboard') }}">Profile</a>
                                        or 
                                        <a id="logout" href="javascript:;" data-url="{{ route('logout') }}">Logout</a>
                                    @else
                                        <a href="{{ route('login') }}">Login</a>
                                        or 
                                        <a href="{{ route('register') }}">Register</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div id="contactPhone" class="contact_phone order-md-last">
                <i class="linearicons-phone-wave"></i>
                <span>123-456-7689</span>
            </div>
        </div>
    </div>
</div>