@extends('frontend.layouts.app', ['title' => 'Register ', get_settings('system_name')])
@push('page_meta_information')
    
    <link rel="canonical" href="{{ route('home') }}" />
    <meta name="referrer" content="origin">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta name="title" content="Register for a new Account | {{ get_settings('system_name') }}">
@endpush
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/parsley.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/toastr.min.css') }}">
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
                            Register Account
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
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
                                    <h3>Register Account</h3>
                                </div>
                                <form method="POST" id="register-form" action="{{ route('register.post') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="customer_first_name">First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="customer_first_name" id="customer_first_name" class="form-control" required placeholder="First Name">
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="customer_last_name">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" name="customer_last_name" id="customer_last_name" class="form-control" required placeholder="Last Name">
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="customer_email">E-Mail <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="customer_email" class="form-control" required placeholder="E-Mail">
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="customer_phone">Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="customer_phone" id="customer_phone" class="form-control" required placeholder="Phone">
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                                            <div class="progress mt-2">
                                                <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small id="password-strength-text"></small>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <button type="submit" style="display: none;" class="btn btn-fill-out btn-block" id="submit">
                                                Register 
                                            </button>
                                            <button class="btn btn-dark btn-block"  id="submitting" type="button">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div class="different_login">
                                    <span> Already have an account</span>
                                </div>
                                <div class="form-note text-center">If you already have an account with us, please login at the <a href="{{ route('login') }}">login</a> page.</div>
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
    <script src="{{ asset('frontend/assets/js/pages/register.js') }}"></script>
@endpush