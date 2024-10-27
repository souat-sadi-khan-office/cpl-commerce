@extends('frontend.layouts.app', ['title' => 'Login | '. get_settings('system_name')])

@push('page_meta_information')
    
    <link rel="canonical" href="{{ route('home') }}" />
    <meta name="referrer" content="origin">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta name="title" content="Login | {{ get_settings('system_name') }}">
@endpush

@push('breadcrumb')
<div class="breadcrumb_section page-title-mini">
    <div class="custom-container">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="linearicons-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Account Login
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endpush
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/css/parsley.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/toastr.min.css') }}">
@endpush
@section('content')
    <div class="main_content bg_gray">

        <div class="login_register_wrap section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-md-10">
                        <div class="login_wrap">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <h3>Account Login</h3>
                                </div>
                                <form method="POST" id="login-form" action="{{ route('login.post') }}">
                                    <div class="row">
                                        <!-- email -->
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="email">E-Mail <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" placeholder="E-Mail" required>
                                        </div>

                                        <!-- password -->
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="login_footer form-group mb-3">
                                        <div class="chek-form">
                                            <div class="custome-checkbox">
                                                <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                                <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                            </div>
                                        </div>
                                        <a href="{{ route('forget-password') }}">Forgot password?</a>
                                    </div>
                                    <div class="form-group mb-3">
                                        <button style="display: none;" type="submit" id="submit" class="btn btn-fill-out btn-block" name="login">Log in</button>
                                    </div>
                                    <div class="form-group mb-3">
                                        <button class="btn btn-dark btn-block" disabled id="submitting" type="button">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </button>
                                    </div>
                                </form>
                                <div class="different_login">
                                    <span> or</span>
                                </div>
                                <ul class="btn-login list_none text-center">
                                    <li>
                                        <a href="{{ route('login.facebook') }}" class="btn btn-facebook">
                                            <i class="ion-social-facebook"></i>
                                            Facebook
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('google.login') }}" class="btn btn-google">
                                            <i class="ion-social-googleplus"></i>
                                            Google
                                        </a>
                                    </li>
                                </ul>
                                <div class="form-note text-center">Don't Have an Account? <a href="{{ route('register') }}">Sign up now</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection
@push('scripts')
    
    <script src="{{ asset('backend/assets/js/parsley.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/pages/login.js') }}"></script>
@endpush