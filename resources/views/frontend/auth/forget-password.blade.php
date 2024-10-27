@extends('frontend.layouts.app', ['title' => 'Forgetten Your Password? | '. get_settings('system_name')])

@push('page_meta_information')
    
    <link rel="canonical" href="{{ route('home') }}" />
    <meta name="referrer" content="origin">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta name="title" content="Forget Password | {{ get_settings('system_name') }}">
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
                    <li class="breadcrumb-item">
                        <a href="{{ route('login') }}">
                            Account Login
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Forgotten Password
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
                                    <h3>Forgot Your Password?</h3>
                                </div>
                                <form method="POST" id="login-form" action="">
                                    <div class="row">
                                        <!-- email -->
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="email">Enter Your E-Mail <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" placeholder="E-Mail" required>
                                        </div>
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