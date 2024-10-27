<div class="middle-header dark_skin r">
    <div class="custom-container">
        <div class="nav_block">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img class="logo_light" src="{{ get_settings('system_logo_white') ? asset(get_settings('system_logo_white')) : asset('pictures/default-logo-white.png') }}" alt="System white logo">
                <img class="logo_dark" src="{{ get_settings('system_logo_dark') ? asset(get_settings('system_logo_dark')) : asset('pictures/default-logo-dark.png') }}" alt="System dark logo">
            </a>
            <div class="order-md-2">
                <ul class="navbar-nav attr-nav align-items-center">
                    <li style="cursor: pointer;">
                        <div class="q-actions system-selector">
                            <div class="ac">
                                <a class="ic" href="javascript:;">
                                    <img src="{{ session()->get('country_flag') ? session()->get('country_flag') : asset('pictures/bangladesh.png') }}" alt="Country Flag">
                                </a>
                               
                                <div class="ac-content">
                                    <p id="country_name_selector">{{session()->get('user_country') }}</p>
                                    <h5>
                                        <span id="currency_name_selector">{{ session()->get('currency_code') ? session()->get('currency_code') : 'USD' }}</span>
                                        <svg viewBox="0 0 1024 1024" width="1em" height="1em" fill="currentColor" aria-hidden="false" focusable="false"><path d="M296.256 354.944l224 224 224-224a74.656 74.656 0 0 1 0 105.6l-197.6 197.6a37.344 37.344 0 0 1-52.8 0l-197.6-197.6a74.656 74.656 0 0 1 0-105.6z"></path></svg>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="cart_box" id="globalSelector">
                            <ul class="cart_list country-dropdown">
                                <li>
                                    <div class="row mb-3">
                                        <div class="col-md-12 mb-2 form-group">
                                            <h6>
                                                <b>Ship To</b>

                                                <span class="close-global-selector" style="float:right;">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                            </h6>
                                        </div>
        
                                        <div class="col-md-12 form-group mb-2">
                                            <select id="global_country_id" class="form-control">
                                                @php
                                                    $countries = App\Models\Country::where('status', 1)->orderBy('name', 'ASC')->get();
                                                @endphp
                                                @foreach ($countries as $country)
                                                    <option {{ session()->get('user_country') ? (session()->get('user_country') == $country->name ? 'selected' : '') : '' }} data-image="{{ asset($country->image) }}" value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 form-group">
                                            <h6><b>Language</b></h6>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <select name="language" id="language" class="form-control select">
                                                <option value="en">English</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <h6><b>Currency</b></h6>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <select id="global_currency_id" class="form-control select">
                                                @php
                                                    $currencies = App\Models\Currency::where('status', 1)->orderBy('name', 'ASC')->get();
                                                @endphp
                                                @foreach ($currencies as $currency)
                                                    <option {{ session()->get('currency_id') ? (session()->get('currency_id') == $currency->id ? 'selected' : '') : '' }} value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="cart_footer">
                                <p class="cart_buttons">
                                    <button type="button" id="change-global-method" class="btn-sm btn btn-fill-line btn-block">Save</button>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
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