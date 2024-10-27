@extends('frontend.layouts.app')
@section('title', 'Login ', get_settings('system_name'))

@push('breadcrumb')
<div class="breadcrumb_section page-title-mini">
    <div class="custom-container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="linearicons-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            Account
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Quote
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="section bg_gray">
	<div class="custom-container">
        <div class="row">
            @include('frontend.customer.partials.sidebar')
            <div class="col-lg-9 col-md-8 dashboard_content">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        @include('frontend.customer.partials.header')
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="h5">Quote History</h1>
                            </div>
                            <div class="card-body">
                                <ul class="list-group custom-list">
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <img src="https://www.startech.com.bd/image/cache/catalog/processor/amd/ryzen-5-5600g/ryzen-5-5600g-228x228.jpg" alt="One">
                                                    </div>
                                                    <div class="col">
                                                        <p>This is the product name</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <p>$78.00 for 1 item</p>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" class="btn btn-fill-line btn-sm">Dark</a>
                                                <a href="#" class="btn btn-fill-out btn-sm">View</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                
			</div>
		</div>
	</div>
</div>
@endsection