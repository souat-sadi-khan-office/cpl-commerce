@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page_name')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="h3 mb-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        
        <div class="col-md-3">

            <a style="text-decoration: none;" href="{{ route('admin.customer.index') }}">
                <div class="info-box mb-3 text-bg-warning"> 
                    <span class="info-box-icon"> 
                        <i class="bi bi-tag-fill"></i> 
                    </span>
                    <div class="info-box-content"> 
                        <span class="info-box-text">Total Customer</span> 
                        <span class="info-box-number">{{ $number_of_customer }}</span>
                    </div>
                </div>
            </a>

            <a href="javascript:;" style="text-decoration: none;">
                <div class="info-box mb-3 text-bg-success"> 
                    <span class="info-box-icon"> 
                        <i class="bi bi-heart-fill"></i> 
                    </span>
                    <div class="info-box-content"> 
                        <span class="info-box-text">Total Orders</span> 
                        <span class="info-box-number">{{ $number_of_order }}</span> 
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.category.index') }}" style="text-decoration: none;">
                <div class="info-box mb-3 text-bg-danger"> 
                    <span class="info-box-icon"> 
                        <i class="bi bi-columns-gap"></i> 
                    </span>
                    <div class="info-box-content"> 
                        <span class="info-box-text">Total Product Category</span> 
                        <span class="info-box-number">{{ $number_of_category }}</span> 
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.brand-type.index') }}" style="text-decoration: none;">
                <div class="info-box mb-3 text-bg-info"> 
                    <span class="info-box-icon"> 
                        <i class="bi bi-ubuntu"></i> 
                    </span>
                    <div class="info-box-content"> 
                        <span class="info-box-text">Total Product brand</span> 
                        <span class="info-box-number">{{ $number_of_brand }}</span> 
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection

@push('script')

@endpush