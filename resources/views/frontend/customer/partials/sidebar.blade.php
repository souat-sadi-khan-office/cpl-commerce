<div class="col-lg-3 col-md-4">
    <div class="dashboard_menu bg_white">
        <ul class="nav nav-tabs flex-column" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('account/dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('account/my-orders') ? 'active' : '' }}" href="{{ route('account.my_orders') }}">
                    <i class="fas fa-shopping-cart"></i>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('account/quotes') ? 'active' : '' }}" href="{{ route('account.quote') }}">
                    <i class="fas fa-list"></i>
                    Quote
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('account/edit-profile') ? 'active' : '' }}" href="{{ route('account.edit_profile') }}">
                    <i class="fas fa-user"></i>
                    Edit Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('account/change-password') ? 'active' : '' }}" href="{{ route('account.change_password') }}">
                    <i class="fas fa-lock"></i>
                    Change Password
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('account/phone-book*') ? 'active' : '' }}" href="{{ route('account.phone-book.index') }}">
                    <i class="fas fa-mobile-alt"></i>
                    Phone Book
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link {{ Request::is('account/address-book*') ? 'active' : '' }}" href="{{ route('account.address-book.index') }}">
                    <i class="fas fa-globe-americas"></i>
                    Address
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('account/wish-list') ? 'active' : '' }}" href="{{ route('account.wishlist') }}">
                    <i class="far fa-heart"></i>
                    Wish List
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('account/saved-pc') ? 'active' : '' }}" href="{{ route('account.saved_pc') }}">
                    <i class="fas fa-desktop"></i>
                    Saved PC
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link {{ Request::is('account/star-points') ? 'active' : '' }}" href="{{ route('account.star_points') }}">
                    <i class="far fa-star"></i>
                    Star Points
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('account/transaction') ? 'active' : '' }}" href="{{ route('account.transaction') }}">
                    <i class="fas fa-wallet"></i>
                    Your Transactions
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" id="logout" href="javascript:;" data-url="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>