@extends('backend.layouts.app')
@section('title', 'Create New Product')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dropify.min.css') }}">
    <style>
        #imagePreview img {
            max-width: 150px;
            margin: 10px;
            border: 2px solid #ddd;
        }
    </style>
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tempus-dominus.min.css') }}">
@endpush
@section('page_name')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="h3 mb-0">Create new Product</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house-add-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.product.index') }}">
                                Product Management
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create new product</li>
                    </ol>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.product.index') }}" class="btn btn-soft-danger">
                        <i class="bi bi-backspace"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
   
    <form action="{{ route('admin.product.store')}}" method="POST" class="content_form" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <div class="row">
                    <!-- Product Information -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Product Information</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="name">Product name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
            
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="slug">Product slug <span class="text-danger">*</span></label>
                                        <input type="text" name="slug" id="slug" class="form-control" required>
                                    </div>
            
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="category_id">Category <span class="text-danger">*</span></label>
                                        <select name="category_id[]" id="category_id" class="form-control category_id007 select">
                                          
                                        </select>
                                    </div>
            
                                    <div class="Sub_Categories row"></div>
                                   
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="brand_id">Brand</label>
                                        <select name="brand_id" id="brand_id" class="form-control"></select>
                                    </div>
            
                                    <div class="col-md-12 form-group mb-3" style="display:none;" id="brand_type_area">
                                        <label for="brand_type_id">Brand type</label>
                                        <select name="brand_type_id" id="brand_type_id" class="form-control"></select>
                                    </div>
            
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="unit">Unit</label>
                                        <input type="text" name="unit" id="unit" class="form-control" placeholder="Unit (e.g. KG, Pc etc)">
                                    </div>
            
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="min_purchase_quantity">Minimum purchase quantity <span class="text-danger">*</span></label>
                                        <input type="number" name="min_purchase_quantity" id="min_purchase_quantity" class="form-control" value="1" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Images -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Product Images</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="images">Gallery Images (540 X 600)</label>
                                        <input type="file" name="images[]" id="images" class="form-control" multiple data-max-file-size="2M" >
                                        <small class="text-muted">These images are visible in product details page gallery. Use 600x600 sizes images.</small>
                                    </div>

                                    <div id="imagePreview" class="col-md-12.mb-3"></div>
    
                                    <div class="col-md-12 form-group">
                                        <label for="thumb_image">Thumbnail Image (540 X 600)</label>
                                        <input type="file" name="thumb_image" id="thumb_image" class="form-control dropify" data-max-file-size="2M" >
                                        <small class="text-muted">This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Videos -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Product Videos</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="video_provider">Video Provider</label>
                                        <input type="text" name="video_provider" id="video_provider" class="form-control" placeholder="YouTube">
                                    </div>
    
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="video_link">Video Link</label>
                                        <textarea name="video_link" id="video_link" cols="30" rows="4" placeholder="Video Link" class="form-control"></textarea>
                                        <small class="text-muted">Use the proper embed code from youtube.</small>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Description -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Product Description</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @include('backend.components.descriptionInput')
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SEO Meta Tags -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">SEO Meta Tags</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="site_title">Site title</label>
                                        <input type="text" name="site_title" id="site_title" class="form-control" placeholder="Site Title">
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="meta_title">Meta title</label>
                                        <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Meta Title">
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="meta_keyword">Meta keyword</label>
                                        <textarea name="meta_keyword" id="meta_keyword" cols="30" rows="4" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="meta_description">Meta description</label>
                                        <textarea name="meta_description" id="meta_description" cols="30" rows="4" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="meta_article_tags">Meta article tag</label>
                                        <textarea name="meta_article_tags" id="meta_article_tags" cols="30" rows="4" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="meta_script_tags">Meta script tag</label>
                                        <textarea name="meta_script_tags" id="meta_script_tags" cols="30" rows="4" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-md-5">
                <div class="row">

                    <!-- Product Specification -->
                    <div class="col-mb-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Product Specification</h2>
                                <span class="text-danger"> Duplicate Types Will be Not Counted for a Specification Key</span>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="specification_key row"></div>
                                    <button id="add-another" type="button" class="btn btn-primary mt-2" style="display:none;">Add Another
                                        Specification</button>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Product Costing & Pricing -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Product Cost & Pricing </h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- unit_price -->
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="unit_price">Unit Price <span class="text-danger">*</span></label>
                                        <input type="text" name="unit_price" id="unit_price" class="form-control number" value="0" required >
                                    </div>

                                    <!-- quanitiy -->
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                        <input type="text" name="quantity" id="quantity" class="form-control number" value="0" required>
                                        <small class="text-muted">Product quanity must be same on the product stock adding table.</small>
                                    </div>

                                    {{-- <!-- sku -->
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="sku">SKU</label>
                                        <input type="text" name="sku" id="sku" class="form-control">
                                    </div> --}}

                                    <!-- total_price -->
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="total_price">Total Price <span class="text-danger">*</span></label>
                                        <input type="text" name="total_price" id="total_price" class="form-control" value="0" required>
                                        <small class="text-muted">Total Price = Unit Price X Quantity</small>
                                    </div>

                                    <!-- purchase_unit_price -->
                                    <div class="col-md-6 form-goup mb-3">
                                        <label for="purchase_unit_price">Unit Purchase Price </label>
                                        <input type="text" id="purchase_unit_price" name="purchase_unit_price" class="form-control number" value="0" >
                                        <small class="text-muted">This is the product purchase price from sellter.</small>
                                    </div>

                                    <!-- purchase_total_price -->
                                    <div class="col-md-6 form-goup mb-3">
                                        <label for="purchase_total_price">Total Purchase Price </label>
                                        <input type="text" id="purchase_total_price" class="form-control number" value="0" >
                                    </div>

                                    <!-- currency_id -->
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="currency_id">Currency</label>
                                        <select name="currency_id" id="currency_id" disabled class="form-control">
                                            @foreach ($currencies as $currency)
                                                <option {{ get_settings('system_default_currency') == $currency->id ? 'selected' : '' }} value="{{ $currency->id }}">{{ $currency->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- file -->
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="file">File </label>
                                        <input type="file" name="file" id="file" class="form-control">
                                    </div>

                                    <!-- is_selleable -->
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="is_selleable">Is sellable</label>
                                        <select name="is_sellable" id="is_sellable" class="form-contom select">
                                            <option selected value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Stocks -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Product Stocks </h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <div class="alert alert-warning">
                                            <b>Warning</b>: Here product stock must be the same quanity as on the <b>Product costing</b> quanity. You can add stock later.
                                        </div>
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="add_stock_now">Want to add stock now? </label>
                                        <select name="add_stock_now" class="form-control select" id="add_stock_now">
                                            <option selected value="now">Add Now</option>
                                            <option value="later">Add Later</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-3 form-group">
                                        <label for="stock_type">Stock Types <span class="text-danger">*</span></label>
                                        <select name="stock_types" id="stock_types" class="form-control select">
                                            <option selected value="globally">Globally</option>
                                            <option value="zone_wise">Zone wise</option>
                                            <option value="country_wise">Country wise</option>
                                            <option value="city_wise">City Wise</option>
                                        </select>
                                    </div>

                                    <!-- globally_area -->
                                    <div id="globally_area">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="globally_stock_amount">Total in Stock <spna class="text-danger">*</spna></label>
                                            <input type="text" class="form-control number" name="globally_stock_amount" id="globally_stock_amount" required value="0">
                                        </div>
                                    </div>

                                    <!-- zone_wise_area -->
                                    <div id="zone_wise_area" style="display: none">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="zone_wise_id">Zones <span class="text-danger">*</span></label>
                                            <select id="zone_wise_id" class="form-control select" data-placeholder="Select zones">
                                                <option value="">Select zones</option>
                                                @foreach ($zones as $zone)
                                                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="zone_wise_data"></div>
                                    </div>

                                    <!-- country_wise_area -->
                                    <div id="country_wise_area" style="display: none;">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="country_wise_id">Countries <span class="text-danger">*</span></label>
                                            <select name="country_wise_id[]" id="country_wise_id" class="form-control select" data-placeholder="Select countries">
                                                <option value="">Select countries</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="country_wise_data"></div>
                                    </div>

                                    <!-- city_wise_area -->
                                    <div style="display:none;" id="city_wise_area">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="city_wise_id">Cities <span class="text-danger">*</span></label>
                                            <select name="city_wise_id[]" id="city_wise_id" class="form-control select" data-placeholder="Select cities">
                                                <option value="">Select cities</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="city_wise_data"></div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Discount -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Discount</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="is_discounted">Discount Available</label>
                                        <select name="is_discounted" id="is_discounted" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="discount_type">Discount Type </label>
                                        <select name="discount_type" id="discount_type" class="form-control" disabled>
                                            <option value="amount">Amount</option>
                                            <option value="percentage">Percent</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="discount">Amount</label>
                                        <input type="text" name="discount" id="discount" class="form-control" value="0" disabled>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="discount_start_date">Discount start date</label>
                                        <input type="text" name="discount_start_date" id="discount_start_date" class="form-control date" disabled>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="discount_end_date">Discount end date</label>
                                        <input type="text" name="discount_end_date" id="discount_end_date" class="form-control date" disabled>
                                    </div>
                                    <div id="date_error" style="color: red; display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Status -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Status</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <select name="status" id="status" class="form-control select">
                                            <option selected value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="stage">Stage </label>
                                        <select name="stage" id="stage" class="form-control select">
                                            <option selected value="normal">Normal</option>
                                            <option value="pre-order">Pre Order</option>
                                            <option value="upcoming">Upcoming</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Feature Product -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Feature Product</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="is_featured">Feature Product</label>
                                        <select name="is_featured" id="is_featured" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Return Policy -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Return Policy</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="is_returnable">Is Returnable</label>
                                        <select name="is_returnable" id="is_returnable" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
    
                                    <label for="return_deadline">Return Deadline</label>
                                    <div class="col-md-12 input-group mb-3">
                                        <input type="number" min="0" class="form-control" name="return_deadline" id="return_deadline" disabled>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">Days</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Low Stock Quantity Warning -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Low Stock Quantity Warning</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="low_stock_quantity">Quantity</label>
                                        <input type="number" min="0" name="low_stock_quantity" id="low_stock_quantity" class="form-control" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Cash on Delivery -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Cash on Delivery</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="cash_on_delivery">Cash on Delivery</label>
                                        <select name="cash_on_delivery" id="case_on_deliver" class="form-control">
                                            <option value="1">Available</option>
                                            <option value="0">Not available</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Estimate Shipping Time -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Estimate Shipping Time</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <label for="est_shipping_time">Estimate Shipping Time</label>
                                    <div class="col-md-12 input-group mb-3">
                                        <input type="number" min="0" class="form-control" name="est_shipping_time" id="est_shipping_time">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">Days</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Vat & TAX -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0">Vat & TAX</h2>
                            </div>
                            <div class="card-body">
                                @foreach ($taxes as $tax)
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <input type="hidden" name="tax_id[]" value="{{ $tax->id }}">
                                            <label for="taxes_{{ $tax->id }}">{{ $tax->name }}</label>
                                            <input type="number" min="0" name="taxes[]" id="taxes_{{ $tax->id }}" class="form-control" value="0">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="tax_type_{{ $tax->id }}">Type</label>
                                            <select name="tax_types[]" id="tax_type_{{ $tax->id }}" class="form-control">
                                                <option value="flat">Flat</option>
                                                <option value="percent">Percent</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
    
            <div class="col-md-12 form-group mb-3 text-end">
                <button class="btn btn-soft-success" type="submit" id="submit">
                    <i class="bi bi-send"></i>
                    Create
                </button>
                <button class="btn btn-soft-warning" style="display: none;" id="submitting" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src="{{ asset('backend/assets/js/tempus-dominus.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/dropify.min.js') }}"></script>
    <script>
        _componentSelect();
        _formValidation();
        _initCkEditor("editor");

        $('.dropify').dropify({
            imgFileExtensions: ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'webp']
        });

        const element = document.getElementById('discount_start_date');
        const input = document.getElementById('discount_start_date');
        const picker = new tempusDominus.TempusDominus(element, {
            defaultDate: new Date(), // Set today's date as default
            display: {
                components: {
                    calendar: true,
                    date: true,
                    month: true,
                    year: true,
                    decades: true,
                    clock: false // Disable the time selection
                }
            }
        });

        // Event listener to update the input value when the date changes
        element.addEventListener('change.td', (e) => {
            const selectedDate = picker.dates.formatInput(e.detail.date);
            input.value = selectedDate;
        });
        
        const element2 = document.getElementById('discount_end_date');
        const input2 = document.getElementById('discount_end_date');
        const picker2 = new tempusDominus.TempusDominus(element2, {
            defaultDate: new Date(), 
            display: {
                components: {
                    calendar: true,
                    date: true,
                    month: true,
                    year: true,
                    decades: true,
                    clock: false
                }
            }
        });
        
        element2.addEventListener('change.td', (e) => {
            const selectedDate2 = picker2.dates.formatInput(e.detail.date);
            console.log(selectedDate2);
            input2.value = selectedDate2;
        });

        // For image preview
        document.getElementById('images').addEventListener('change', function(event) {
            var imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = '';

            var files = event.target.files;
            
            if (files) {
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    
                    if (file.type.startsWith('image/')) {
                        var reader = new FileReader();
                        
                        reader.onload = function(e) {
                            var imgElement = document.createElement('img');
                            imgElement.src = e.target.result;
                            imgElement.style.maxWidth = '150px';
                            imgElement.style.margin = '10px';
                            imgElement.classList.add('img-thumbnail');
                            
                            imagePreview.appendChild(imgElement);
                        };
                        
                        reader.readAsDataURL(file);
                    }
                }
            }
        });

        $(document).on('change', '#add_stock_now', function() {
            let add_stock_now = $(this).val();
            if(add_stock_now == 'now') {
                $('#stock_types').removeAttr('disabled');
                $('#globally_area').show();
            } else {
                $('#stock_types').attr('disabled', true);
                $('#globally_area').hide();
            }
        })

        $(document).on('change', '#stock_types', function() {
            let stock_type = $(this).val();
            switch(stock_type) {
                case 'globally':
                    $('#globally_area').show();
                    $('#globally_stock_amount').attr('required', true);

                    $('#zone_wise_area').hide();
                    $('#zone_wise_data').html("");

                    $('#country_wise_area').hide();
                    $('#country_wise_data').html("");

                    $('#city_wise_area').hide();
                    $('#city_wise_data').html("");
                break;
                case 'zone_wise':
                    $('#globally_area').hide();
                    $('#globally_stock_amount').removeAttr('required');

                    $('#zone_wise_area').show();

                    $('#country_wise_area').hide();
                    $('#country_wise_data').html("");

                    $('#city_wise_area').hide();
                    $('#city_wise_data').html("");
                break;
                case 'country_wise': 
                    $('#globally_area').hide();
                    $('#globally_stock_amount').removeAttr('required');

                    $('#zone_wise_area').hide();
                    $('#zone_wise_data').html("");

                    $('#country_wise_area').show();

                    $('#city_wise_area').hide();
                    $('#city_wise_data').html("");
                break;
                case 'city_wise': 
                    $('#globally_area').hide();
                    $('#globally_stock_amount').removeAttr('required');

                    $('#zone_wise_area').hide();
                    $('#zone_wise_data').html("");
                    
                    $('#country_wise_area').hide();
                    $('#country_wise_data').html("");

                    $('#city_wise_area').show();
                break;
            }
        });

        $(document).on('change', '#zone_wise_id', function() {
            let zone_id = $(this).val();
            $('#zone_wise_id option').filter(function() {
                return $(this).val() == zone_id;
            }).remove();

            $.ajax({
                url: '/admin/get-zone-information-by-id',
                method: 'POST',
                data: {
                    zone_id: zone_id
                },
                dataType: 'JSON',
                cache: true,
                success: function(data) {
                    var randomNumber = Math.floor(Math.random() * (1000000 - 100000)) + 100000;
                    let content = `
                        <div class="row" id="zone_wise_item_`+ randomNumber +`">
                            <div class="col-md-6 form-group mb-3">
                                <label for="zone_id">Zone <span class="text-danger">*</span></label>
                                <input type="hidden" name="zone_id[]"  value="`+ data.id +`">
                                <input type="text" id="zone_id" disabled class="form-control" value="`+ data.name +`">
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="zone_wise_stock_quantity">Quantity</label>
                                <input type="text" name="zone_wise_stock_quantity[]" id="zone_wise_stock_quanity" class="form-control" required value="0">
                            </div>

                            <div class="col-md-2 form-group mb-3">
                                <button type="button" style="margin-top: 25px;" class="btn btn-sm btn-soft-danger remove_zone_item" data-id="`+ randomNumber +`">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;

                    $('#zone_wise_data').append(content);
                }
            })
        });

        $(document).on('click', '.remove_zone_item', function() {
            let id = $(this).data('id');
            $('#zone_wise_item_'+id).remove();
        });

        $(document).on('change', '#country_wise_id', function() {
            let country_id = $(this).val();
            $('#country_wise_id option').filter(function() {
                return $(this).val() == country_id;
            }).remove();

            $.ajax({
                url: '/admin/get-country-information-by-id',
                method: 'POST',
                data: {
                    country_id: country_id
                },
                dataType: 'JSON',
                cache: true,
                success: function(data) {
                    var randomNumber = Math.floor(Math.random() * (1000000 - 100000)) + 100000;
                    let content = `
                        <div class="row" id="country_wise_item_`+ randomNumber +`">
                            <div class="col-md-6 form-group mb-3">
                                <label for="country_id">Country <span class="text-danger">*</span></label>
                                <input type="hidden" name="country_id[]"  value="`+ data.id +`">
                                <input type="text" id="country_id" disabled class="form-control" value="`+ data.name +`">
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="country_wise_quantity">Quantity</label>
                                <input type="text" name="country_wise_quantity[]" value="0" id="country_wise_quantity" class="form-control" required>
                            </div>

                            <div class="col-md-2 form-group mb-3">
                                <button type="button" style="margin-top: 25px;" class="btn btn-sm btn-soft-danger remove_country_item" data-id="`+ randomNumber +`">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;

                    $('#country_wise_data').append(content);
                }
            })
        });

        $(document).on('click', '.remove_country_item', function() {
            let id = $(this).data('id');
            $('#country_wise_item_'+id).remove();
        });

        $(document).on('change', '#city_wise_id', function() {
            let city_id = $(this).val();
            $('#city_wise_id option').filter(function() {
                return $(this).val() == city_id;
            }).remove();

            $.ajax({
                url: '/admin/get-city-information-by-id',
                method: 'POST',
                data: {
                    city_id: city_id
                },
                dataType: 'JSON',
                cache: true,
                success: function(data) {
                    var randomNumber = Math.floor(Math.random() * (1000000 - 100000)) + 100000;
                    let content = `
                        <div class="row" id="city_wise_item_`+ randomNumber +`">
                            <div class="col-md-6 form-group mb-3">
                                <label for="city_id">City <span class="text-danger">*</span></label>
                                <input type="hidden" name="city_id[]"  value="`+ data.id +`">
                                <input type="text" id="city_id" disabled class="form-control" value="`+ data.name +`">
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="city_wise_quantity">Quantity</label>
                                <input type="text" name="city_wise_quantity[]" id="city_wise_quantity" class="form-control" value="0">
                            </div>

                            <div class="col-md-2 form-group mb-3">
                                <button type="button" style="margin-top: 25px;" class="btn btn-sm btn-soft-danger remove_city_item" data-id="`+ randomNumber +`">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;

                    $('#city_wise_data').append(content);
                }
            })
        });

        $(document).on('click', '.remove_city_item', function() {
            let id = $(this).data('id');
            $('#city_wise_item_'+id).remove();
        });

        $(document).on('keyup', '#unit_price', function() {
            let unit_price = parseInt($(this).val());
            let quantity = parseInt($('#quantity').val());
            let total_price = unit_price * quantity;

            $('#total_price').val(total_price);
        })

        $(document).on('keyup', '#quantity', function() {
            let quantity = parseInt($(this).val());
            let unit_price = parseInt($('#unit_price').val());
            let total_price = unit_price * quantity;

            $('#total_price').val(total_price);
        });

        $(document).on('keyup', '#purchase_unit_price', function() {
            let purchase_unit_price = $(this).val();
            let quantity = $('#quantity').val();
            let total_price = parseInt(purchase_unit_price) * parseInt(quantity);

            $('#purchase_total_price').val(total_price);
        })
        
        $(document).ready(function() {
            $('#discount_start_date, #discount_end_date').on('change', function() {
                const startDateValue = $('#discount_start_date').val();
                const endDateValue = $('#discount_end_date').val();
                const $errorDiv = $('#date_error');

                // Clear any previous error message
                $errorDiv.empty();

                // Check if start date is valid and not older than today
                const today = new Date();
                const startDate = new Date(startDateValue);

                // Check if the end date is empty
                if (!endDateValue) {
                    $errorDiv.text('End date cannot be null.').show();
                    return; // Exit the function if the end date is null
                }

                // Validate if end date is earlier than start date
                const endDate = new Date(endDateValue);
                if (endDate < startDate) {
                    $errorDiv.text('End date must be greater than or equal to start date.').show();
                } else {
                    $errorDiv.hide(); // Hide the error message if the dates are valid
                }
            });
        });

        function generateSlug(name) {
            return name
                .toString()
                .toLowerCase()
                .trim()
                .replace(/&/g, '-and-')
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-') 
                .replace(/-+/g, '-');
        }

        $('#name').on('input', function() {
            const name = $(this).val();
            const slug = generateSlug(name);
            $('#slug').val(slug);

            // Check if the slug exists
            $.ajax({
                url: '{{ route('admin.slug.check') }}',
                type: 'GET',
                data: {
                    slug: slug,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.exists) {
                        const timestamp = Date.now();
                        $('#slug').val(slug + '-' + timestamp);
                    }
                }
            });
        });

    </script>
    <script src="{{ asset('backend/assets/js/addproduct.js') }}"></script>
@endpush
