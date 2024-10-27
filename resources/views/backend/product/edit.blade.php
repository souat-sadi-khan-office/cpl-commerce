@extends('backend.layouts.app')
@section('title', 'Update Product Information')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tempus-dominus.min.css') }}">
    <style>
        #imagePreview img {
            max-width: 150px;
            margin: 10px;
            border: 2px solid #ddd;
        }
    </style>
@endpush

@section('page_name')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="h3 mb-0">Update product information</h1>
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
                        <li class="breadcrumb-item active" aria-current="page">Update product information</li>
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

    <form action="{{ route('admin.product.update', $model->id) }}" method="POST" class="content_form"
        enctype="multipart/form-data">
        @csrf
        @method('PATCH')
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
                                        <input type="text" name="name" id="name" class="form-control" required
                                            value="{{ $model->name }}">
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="slug">Product slug <span class="text-danger">*</span></label>
                                        <input type="text" name="slug" id="slug" class="form-control" required
                                            value="{{ $model->slug }}">
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="category_id">Category <span class="text-danger">*</span></label>
                                        <input type="hidden" id="defaultCategoryImage"
                                            value="{{ asset($model->category->photo) }}">
                                        <select name="category_id[]" id="category_id"
                                            class="form-control category_id007 select">
                                            @if ($model->category_id)
                                                <option selected value="{{ $model->category_id }}">
                                                    {{ $model->category->name }}</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="Sub_Categories row"></div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="brand_id">Brand</label>
                                        <select name="brand_id" id="brand_id" class="form-control">
                                            @if ($model->brand_id)
                                                <option selected value="{{ $model->brand_id }}">{{ $model->brand->name }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>

                                    @if ($model->brand_type_id != null)
                                        <div class="col-md-12 form-group mb-3" id="brand_type_area">
                                            <label for="brand_type_id">Brand type</label>
                                            <select name="brand_type_id" id="brand_type_id" class="form-control select">
                                                @if ($brandTypes)
                                                    @foreach ($brandTypes as $brandType)
                                                        <option {{ $brandType->id == $model->brand_type_id ? 'selected' : '' }} value="{{ $brandType->id }}">{{ $brandType->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    @else   
                                        <div class="col-md-12 form-group mb-3" style="display:none;" id="brand_type_area">
                                            <label for="brand_type_id">Brand type</label>
                                            <select name="brand_type_id" id="brand_type_id" class="form-control"></select>
                                        </div>
                                    @endif
                                    
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
                                        <input type="file" name="images[]" id="images" class="form-control" multiple
                                            data-max-file-size="2M">
                                        <small class="text-muted">These images are visible in product details page gallery.
                                            Use 600x600 sizes images.</small>
                                    </div>

                                    <div id="imagePreview" class="col-md-12.mb-3">
                                        @if ($model->image)
                                            <div class="row">
                                                @foreach ($model->image as $key => $image)
                                                    <div class="col-md-2">
                                                        <img src="{{ asset($image->image) }}"
                                                            alt="{{ $model->title . ' - ' . $key }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="thumb_image">Thumbnail Image (540 X 600)</label>
                                        <input type="file" name="thumb_image" id="thumb_image"
                                            class="form-control dropify" data-max-file-size="2M"
                                            data-default-file="{{ $model->thumb_image ? asset($model->thumb_image) : '' }}">
                                        <small class="text-muted">This image is visible in all product box. Use 300x300
                                            sizes image. Keep some blank space around main object of your image as we had to
                                            crop some edge in different devices to make it responsive.</small>
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
                                        <input type="text" name="video_provider" id="video_provider"
                                            class="form-control" placeholder="YouTube" value="{{ $model->video_provider }}">
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="video_link">Video Link</label>
                                        <textarea name="video_link" id="video_link" cols="30" rows="4" class="form-control">{{ $model->video_link }}</textarea>
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
                                    @include('backend.components.descriptionInput', [
                                        'description' => $model->details->description,
                                    ])
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
                                        <input type="text" name="site_title" id="site_title" class="form-control"
                                            placeholder="Site Title" value="{{ $model->details->site_title }}">
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="meta_title">Meta title</label>
                                        <input type="text" name="meta_title" id="meta_title" class="form-control"
                                            placeholder="Meta Title" value="{{ $model->details->meta_title }}">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="meta_keyword">Meta keyword</label>
                                        <textarea name="meta_keyword" id="meta_keyword" cols="30" rows="4" class="form-control">{{ $model->details->meta_keyword }}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="meta_description">Meta description</label>
                                        <textarea name="meta_description" id="meta_description" cols="30" rows="4" class="form-control">{{ $model->details->meta_description }}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="meta_article_tags">Meta article tag</label>
                                        <textarea name="meta_article_tags" id="meta_article_tags" cols="30" rows="4" class="form-control">{{ $model->details->meta_article_tags }}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="meta_script_tags">Meta script tag</label>
                                        <textarea name="meta_script_tags" id="meta_script_tags" cols="30" rows="4" class="form-control">{{ $model->details->meta_script_tags }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="row">

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
                                            <option {{ $model->is_discounted == 0 ? 'selected' : '' }} value="0">No
                                            </option>
                                            <option {{ $model->is_discounted == 1 ? 'selected' : '' }} value="1">Yes
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="discount_type">Discount Type </label>
                                        <select name="discount_type" id="discount_type" class="form-control"
                                            {{ $model->is_discounted == 0 ? 'disabled' : '' }}>
                                            <option {{ $model->discount_type == 'amount' ? 'selected' : '' }}
                                                value="amount">Amount</option>
                                            <option {{ $model->discount_type == 'amount' ? 'percentage' : '' }}
                                                value="percentage">Percent</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="discount">Amount</label>
                                        <input type="text" name="discount" id="discount" class="form-control"
                                            value="{{ $model->discount }}"
                                            {{ $model->is_discounted == 0 ? 'disabled' : '' }}>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="discount_start_date">Discount start date</label>
                                        <input type="text" name="discount_start_date" id="discount_start_date"
                                            class="form-control date" {{ $model->is_discounted == 0 ? 'disabled' : '' }}
                                            value="{{ $model->discount_start_date ? get_system_date($model->discount_start_date) : '' }}">
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="discount_end_date">Discount end date</label>
                                        <input type="text" name="discount_end_date" id="discount_end_date"
                                            class="form-control date" {{ $model->is_discounted == 0 ? 'disabled' : '' }}
                                            value="{{ $model->discount_end_date ? get_system_date($model->discount_end_date) : '' }}">
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
                                        <select name="status" id="status" class="form-control">
                                            <option {{ $model->status == '1' ? 'selected' : '' }} value="1">Active</option>
                                            <option {{ $model->status == '0' ? 'selected' : '' }} value="0">Inactive
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="stage">Stage </label>
                                        <select name="stage" id="stage" class="form-control select">
                                            <option {{ $model->stage == 'normal' ? 'selected' : '' }} value="normal">Normal</option>
                                            <option {{ $model->stage == 'pre-order' ? 'selected' : '' }} value="pre-order">Pre Order</option>
                                            <option {{ $model->stage == 'upcoming' ? 'selected' : '' }} value="upcoming">Upcoming</option>
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
                                            <option {{ $model->is_featured == 0 ? 'selected' : '' }} value="0">No
                                            </option>
                                            <option {{ $model->is_featured == 1 ? 'selected' : '' }} value="1">Yes
                                            </option>
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
                                            <option {{ $model->is_returnable == 0 ? 'selected' : '' }} value="0">No
                                            </option>
                                            <option {{ $model->is_returnable == 1 ? 'selected' : '' }} value="1">Yes
                                            </option>
                                        </select>
                                    </div>

                                    <label for="return_deadline">Return Deadline</label>
                                    <div class="col-md-12 input-group mb-3">
                                        <input type="text" min="0" class="form-control number"
                                            name="return_deadline" id="return_deadline"
                                            {{ $model->is_returnable == 0 ? 'disabled' : '' }}
                                            value="{{ $model->return_deadline }}">
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
                                        <input type="number" min="0" name="low_stock_quantity"
                                            id="low_stock_quantity" class="form-control"
                                            value="{{ $model->details ? $model->details->low_stock_quantity : 0 }}">
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
                                            <option
                                                {{ $model->details ? ($model->details->cash_on_delivery == 1 ? 'selected' : '') : 0 }}
                                                value="1">Available</option>
                                            <option
                                                {{ $model->details ? ($model->details->cash_on_delivery == 0 ? 'selected' : '') : 0 }}
                                                value="0">Not available</option>
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
                                        <input type="text" min="0" class="form-control number"
                                            name="est_shipping_time" id="est_shipping_time"
                                            value="{{ $model->details ? $model->details->est_shipping_days : '' }}">
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
                                @foreach ($model->taxes as $tax)
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <input type="hidden" name="tax_id[]" value="{{ $tax->id }}">
                                            <label for="taxes_{{ $tax->id }}">{{ $tax->tax_model->name }}</label>
                                            <input type="text" min="0" name="taxes[]"
                                                id="taxes_{{ $tax->id }}" class="form-control"
                                                value="{{ $tax->tax }}">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="tax_type_{{ $tax->id }}">Type</label>
                                            <select name="tax_types[]" id="tax_type_{{ $tax->id }}"
                                                class="form-control">
                                                <option {{ $tax->tax_type == 'amount' ? 'select' : '' }} value="flat">
                                                    Flat</option>
                                                <option {{ $tax->tax_type == 'pencent' ? 'select' : '' }} value="percent">
                                                    Percent</option>
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
                    Update
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
    <script src="{{ asset('backend/assets/js/dropify.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/tempus-dominus.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            _componentSelect();
            _formValidation();
            _initCkEditor("editor");

            $('.dropify').dropify({
                imgFileExtensions: ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'webp']
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

            const element = document.getElementById('discount_start_date');
            const input = document.getElementById('discount_start_date');
            const picker = new tempusDominus.TempusDominus(element, {
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

            const element1 = document.getElementById('discount_end_date');
            const input1 = document.getElementById('discount_end_date');
            const picker1 = new tempusDominus.TempusDominus(element1, {
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

            $('#discount_start_date, #discount_end_date').on('change', function() {
                const startDateValue = $('#discount_start_date').val();
                const endDateValue = $('#discount_end_date').val();
                const $errorDiv = $('#date_error');

                $errorDiv.empty();

                const today = new Date();
                const startDate = new Date(startDateValue);

                if (!endDateValue) {
                    $errorDiv.text('End date cannot be null.').show();
                    return;
                }

                const endDate = new Date(endDateValue);
                if (endDate < startDate) {
                    $errorDiv.text('End date must be greater than or equal to start date.').show();
                } else {
                    $errorDiv.hide();
                }
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
                        id: '{{ $model->id }}',
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
        });
    </script>
    <script src="{{ asset('backend/assets/js/addproduct.js') }}"></script>
@endpush
