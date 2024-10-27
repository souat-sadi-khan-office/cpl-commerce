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
                        Saved PC
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
                                <h1 class="h5">Saved PC</h1>
                            </div>
                            <div class="card-body">
                                <ul class="list-group custom-list">
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                #110302 - 123212312312312
                                            </div>
                                            <div class="col-md-2">
                                                Date Added
                                                <br>
                                                22/06/2023 12:58:07
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <a href="#" class="btn btn-fill-line btn-sm">
                                                    View
                                                </a>
                                                <a href="#" class="btn btn-fill-out btn-sm">
                                                    <i class="ti-trash"></i>
                                                </a>
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