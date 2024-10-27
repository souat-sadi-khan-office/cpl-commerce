@extends('frontend.layouts.app', ['title' => 'All Brands - '. get_settings('system_name')])

@push('page_meta_information')

    <link rel="canonical" href="{{ route('home') }}" />
    <meta name="referrer" content="origin">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta name="title" content="All Brands - {{ get_settings('system_name') }}">
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
                            All Categories
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endpush
@section('content')
<div class="main_content bg_gray py-5">

    <div class="custom-container">
        @foreach ($brands as $brand)
            <div class="mb-3 bg-white shadow-sm rounded">
                <div class="p-3 border-bottom fs-16 fw-600">
                    <a href="{{ route('slug.handle', $brand->slug) }}" class="text-reset">
                        {{ $brand->name }}
                    </a>
                </div>
                <div class="p-3 p-lg-4">
                    <div class="row">
                        @if ($brandTypes = $brand->types->where('status', 1))
                            @foreach ($brandTypes as $brandType)
                                <div class="col-lg-4 col-6 text-left">
                                    <h6 class="mb-3">
                                        {{ $brandType->name }}
                                    </h6>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
@push('scripts')
    <script src="{{ asset('backend/assets/js/parsley.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/pages/login.js') }}"></script>
@endpush