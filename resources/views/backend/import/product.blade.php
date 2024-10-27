@extends('backend.layouts.app')
@section('title', 'Product Bulk Import')
@section('page_name')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="h3 mb-0">Product Bulk Import</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house-add-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Product Bulk Import</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        <strong>Step One:</strong>
                        <p>1. Download the skeleton file and fill it with proper data.</p>
                        <p>2. You can download the example file to understand how the data must be filled.</p>
                        <p>3. Once you have downloaded and filled the skeleton file, upload it in the form below and submit.</p>
                        <p>4. After uploading product you can edit them and set images and others.</p>
                    </div>
                    <br>
                    <div class="">
                        <a class="btn btn-sm btn-info" href="{{ asset('download/product_bulk_demo.xlsx') }}" download>
                            Download CSV
                        </a>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card card-body">
                        <form action="{{ route('admin.upload.product') }}" method="POST" enctype="multipart/form-data" class="content_form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mt-3 form-group">
                                    <h4>Upload Product File</h4>
                                </div>

                                <div class="col-md-6 mb-3 form-group">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" required data-parsley-errors-container="#category_id_error" id="category_id" class="form-control"></select>
                                    <span id="category_id_error"></span>
                                </div>
                                <div class="col-md-6 mb-3 form-group">
                                    <label for="brand_id">Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-control"></select>
                                    <span id="brand_id_error"></span>
                                </div>

                                <div class="col-md-4 mb-3 form-group">
                                    <input type="file" name="file" id="file" required accept=".csv, .xls, .xlsx" class="form-control">
                                </div>

                                <div class="col-md-12 mb-3 form-group">
                                    <button type="submit" class="btn btn-sm btn-outline-success"  id="submit">
                                        <i class="bi bi-send"></i>
                                        Upload
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning" style="display: none;" id="submitting" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@push('script')
    <script>
        _formValidation();

        // for category searching
        $('#category_id').select2({
            width: '100%',
            placeholder: 'Select category',
            templateResult: formatCategoryOption, 
            templateSelection: formatCategorySelection,
            ajax: {
                url: '/search/category',
                method: 'POST',
                dataType: 'JSON',
                delay: 250,
                cache: true,
                data: function (data) {
                    return {
                        searchTerm: data.term
                    };
                },

                processResults: function (response) {
                    return {
                        results:response
                    };
                }
            }
        });

        function formatCategoryOption(category) {
            if (!category.id) {
                return category.text;
            }

            var categoryImage = '<img src="' + category.image_url + '" class="img-flag" style="height: 20px; width: 20px; margin-right: 10px;" />';
            var categoryOption = $('<span>' + categoryImage + category.text + '</span>');
            return categoryOption;
        }

        function formatCategorySelection(category) {

            if (!category.id) {
                return category.text;
            }

            var defaultImageUrl = $('#default_category_image').val();
            var image_url = category.image_url ? category.image_url : defaultImageUrl;

            var categoryImage = '<img src="' + image_url + '" class="img-flag" style="height: 20px; width: 20px; margin-right: 10px;" />';
            return $('<span>' + categoryImage + category.text + '</span>');
        }

        // for brands
        $('#brand_id').select2({
            width: '100%',
            placeholder: 'Select Brand',
            templateResult: formatBrandOption, 
            templateSelection: formatBrandSelection,
            ajax: {
                url: '/search/brands',
                method: 'POST',
                dataType: 'JSON',
                delay: 250,
                cache: true,
                data: function (data) {
                    return {
                        searchTerm: data.term
                    };
                },

                processResults: function (response) {
                    return {
                        results:response
                    };
                }
            }
        });

        function formatBrandOption(brand) {
            if (!brand.id) {
                return brand.text;
            }

            var brandImage = '<img src="' + brand.image_url + '" class="img-flag" style="height: 20px; width: 20px; margin-right: 10px;" />';
            var brandOption = $('<span>' + brandImage + brand.text + '</span>');
            return brandOption;
        }

        function formatBrandSelection(brand) {
            if (!brand.id) {
                return brand.text;
            }

            var defaultImageUrl = $('#default_brand_image').val();
            var image_url = brand.image_url ? brand.image_url : defaultImageUrl;

            var brandImage = '<img src="' + image_url + '" class="img-flag" style="height: 25px; width: 25px; margin-right: 10px;" />';
            return $('<span>' + brandImage + brand.text + '</span>');
        }
    </script>
@endpush