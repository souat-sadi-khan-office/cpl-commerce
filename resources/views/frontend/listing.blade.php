@extends('frontend.layouts.app', ['title' => $model->site_title ])

@push('page_meta_information')

    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta property="og:site_name" content="{{ get_settings('system_name') }}">
    
    <meta name="title" content="{{ $model->meta_title }}">
    <meta name="author" content="{{ get_settings('system_name') }} : {{ route('home') }}">
    <meta name="keywords" content="{{ $model->meta_keyword }}" />
    <meta name="description" content="{{ $model->meta_description }}">	

    <!-- For Open Graph -->
    <meta property="og:url" content="{{ route('home') }}">	
    <meta property="og:type" content="Product">
    <meta property="og:title" content="{{ $model->meta_title }}">	
    <meta property="og:description" content="{{ $model->meta_description }}">	
    <meta property="og:image" content="{{ asset($model->photo) }}">	

    <!-- For Twitter -->
    <meta name="twitter:card" content="Product" />
    <meta name="twitter:creator" content="{{ get_settings('system_name') }}" /> 
    <meta name="twitter:title" content="{{ $model->meta_title }}" />
    <meta name="twitter:description" content="{{ $model->meta_description }}" />	
    <meta name="twitter:site" content="{{ route('home') }}" />		
    <meta name="twitter:image" content="{{ asset($model->photo) }}">
    {!! $model->meta_article_tags !!}   

@endpush

@push('breadcrumb')
    <div class="breadcrumb_section page-title-mini">
        <div class="custom-container">
            <div class="row align-items-center">
                <div class="col-md-12 mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                <i class="linearicons-home"></i>
                            </a>
                        </li>
                        @foreach ($breadcrumb as $category)
                            <li class="breadcrumb-item">
                                <a href="{{ route('slug.handle', ['slug' => $category->slug]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                        <li class="breadcrumb-item active">
                            {{ $model->name }}
                        </li>
                    </ol>
                </div>

                <div class="col-md-12 listing-headers">
                    @if ($model->header)
                        <h1>{{ $model->header }}</h1>
                    @endif
                    @if ($model->short_description)
                        <p>{{ $model->short_description }}</p>
                    @endif
                </div>

                <div class="sub-categories col-md-12">
                    @if ($model->children)
                        @foreach ($model->children as $sub_category)
                            <a class="btn btn-line-fill btn-sm" href="{{ $sub_category->slug }}">
                                {{ $sub_category->name }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endpush
@push('styles')
    
@endpush
@section('content')
    <div class="section bg_gray">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row align-items-center mb-4 pb-1">
                        <div class="col-12">
                            <div class="product_header bg_white">
                                <div class="product_header_left">
                                    <h4><b>{{ $model->name }}</b></h4>

                                    <button class="tool-btn btn btn-line-fill btn-sm" id="lc-toggle">
                                        <i class="fas fa-filter"></i>
                                        Filter
                                    </button>
                                </div>
                                <div class="product_header_right">
                                    <div class="products_view">
                                        <a href="javascript:;" class="shorting_icon grid active">
                                            <i class="fas fa-th-large"></i>
                                        </a>
                                        <a href="javascript:;" class="shorting_icon list">
                                            <i class="fas fa-list"></i>
                                        </a>
                                    </div>
                                    {{-- <div class="custom_select number-of-data-show">
                                        <select class="form-control form-control-sm">
                                            <option value="">Showing</option>
                                            <option value="9">9</option>
                                            <option value="12">12</option>
                                            <option value="18">18</option>
                                        </select>
                                    </div> --}}
                                    <div class="custom_select">
                                        <select id="sort-by" class="form-control form-control-sm">
                                            <option value="popularity">Sort by popularity</option>
                                            <option value="date">Sort by newness</option>
                                            <option value="price">Sort by price: low to high</option>
                                            <option value="price-desc">Sort by price: high to low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="shop_container grid" id="product-area">
                        @include('frontend.components.product_list')
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{-- {{ $products->links() }} --}}
                            {{-- <ul class="pagination mt-3 justify-content-center pagination_style1">
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="linearicons-arrow-right"></i></a></li>
                            </ul> --}}
                        </div>
                    </div>
                    <div class="row mt-3 description">
                        <div class="bg_white col-md-12">
                            {!! $model->description !!}
                        </div>
                    </div>
                </div>

                <!-- Filtering Options -->
                <div id="column-left" class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                    <span class="lc-close">
                        <i class="fas fa-times"></i>
                    </span>
                    <div class="sidebar filters">
                        <div class="accordion" id="categoryFilterOptions">
                            <div class="widget">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flash-price-range">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#price-range-filter" aria-expanded="false" aria-controls="price-range-filter">
                                            Price Range
                                        </button>
                                    </h2>
                                    <div id="price-range-filter" class="accordion-collapse collapse show" aria-labelledby="flash-price-range">
                                        <div class="accordion-body">
                                            <div class="filter_price">
                                                <div id="price_filter" data-min="0" data-max="50000" data-min-value="0" data-max-value="50000" data-price-sign="$"></div>
                                                <div class="price_range">
                                                    <span>Price: <span id="flt_price"></span></span>
                                                    <input type="hidden" id="price_first">
                                                    <input type="hidden" id="price_second">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Availability -->
                            <div class="widget">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stock-availability-filter" aria-expanded="false" aria-controls="stock-availability-filter">
                                            Stock Availability
                                        </button>
                                    </h2>
                                    <div id="stock-availability-filter" class="accordion-collapse collapse show" aria-labelledby="flash-stock-availability">
                                        <div class="accordion-body">
                                            <ul class="list_brand">
                                                <li>
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input form-check-global form-check" type="checkbox" name="in_stock_availability" id="in_stock_availability" value="">
                                                        <label class="form-check-label" for="in_stock_availability"><span>In Stock</span></label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input form-check-global form-check" type="checkbox" name="out_of_stock_availability" id="out_of_stock_availability" value="">
                                                        <label class="form-check-label" for="out_of_stock_availability"><span>Out of Stock</span></label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input form-check-global form-check" type="checkbox" name="pre_order_availability" id="pre_order_availability" value="">
                                                        <label class="form-check-label" for="pre_order_availability"><span>Pre Order</span></label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input form-check-global form-check" type="checkbox" name="up_coming_availability" id="up_coming_availability" value="">
                                                        <label class="form-check-label" for="up_coming_availability"><span>Up Comming</span></label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Brand -->
                            <div class="widget">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#brand-filter" aria-expanded="false" aria-controls="brand-filter">
                                            Brand
                                        </button>
                                    </h2>
                                    <div id="brand-filter" class="accordion-collapse collapse show" aria-labelledby="flash-brand">
                                        <div class="accordion-body scrollbar">
                                            <ul class="list_brand">
                                                @php
                                                    $brands = App\Models\Brand::select('id','name', 'slug')->where('status', 1)->where('is_featured', 1)->orderBy('name', 'ASC')->get();
                                                @endphp
                                                @foreach ($brands as $brand)
                                                    <li>
                                                        <div class="custome-checkbox">
                                                            <input class="form-check-input" type="checkbox" name="brand" id="brand-{{ $brand->id }}" value="{{ $brand->id }}">
                                                            <label class="form-check-label" for="brand-{{ $brand->id }}"><span>{{ $brand->name }}</span></label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($keys = \App\Models\SpecificationKey::where('status', 1)->whereIn('category_id', $categoryIdArray)->get())
                                @foreach($keys as $key) 
                                    @if ($types = $key->types->where('status', 1)->where('show_on_filter', 1))
                                        @foreach ($types as $type)
                                            <div class="widget">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ Str::slug($type->name) }}-filter" aria-expanded="false" aria-controls="{{ Str::slug($type->name) }}-filter">
                                                            {{ $type->filter_name }}
                                                        </button>
                                                    </h2>
                                                    <div id="{{ Str::slug($type->name) }}-filter" class="accordion-collapse collapse show" aria-labelledby="flash-{{ Str::slug($type->name) }}">
                                                        <div class="accordion-body scrollbar">
                                                            <ul class="list_brand">
                                                                @if ($attributes = $type->attributes->where('status', 1))
                                                                    @foreach ($attributes as $attr)
                                                                        <li>
                                                                            <div class="custome-checkbox">
                                                                                <input class="form-check-input" type="checkbox" name="specification" id="specification-{{ $attr->id }}" value="{{ $attr->id }}">
                                                                                <label class="form-check-label" for="specification-{{ $attr->id }}"><span>{{ $attr->name }}</span></label>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                    @endif
                                @endforeach
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" id="routeCID" name="routeCID" value="{{$model->id}}">
@endsection
@php
    $currentUrl = url()->current();
@endphp
@push('scripts')
    <script>
        $(document).ready(function() {
            // $('.form-check-global').on('change', function() {
            //     filterProducts();
            // });
            
            $('.form-check, .custom_select select').on('change', function() {
                filterProducts();
            });

            // Brand filter
            $('input[name^="brand"]').on('change', function () {
                filterProducts();
            });

            // Specification filter
            $('input[name^="specification"]').on('change', function () {
                filterProducts();
            });

            function filterProducts() {
                // get the checkbox value
                var in_stock = $('#in_stock_availability').is(':checked');
                var out_of_stock = $('#out_of_stock_availability').is(':checked');
                var pre_order = $('#pre_order_availability').is(':checked');
                var up_coming = $('#up_coming_availability').is(':checked');

                // get the selectbox value
                var sortBy = $('#sort-by').val();
                var showData = $('.number-of-data-show select').val();

                var brands = [];
                var specifications = [];

                // Get selected brands
                $('input[name^="brand"]:checked').each(function () {
                    brands.push($(this).val());
                });

                // Get selected specifications
                $('input[name^="specification"]:checked').each(function () {
                    specifications.push($(this).val());
                });

                // AJAX POST Request
                var catId = $('#routeCID').val();

                $('.overlay-loader').show();
                $.ajax({
                    url: '{{ route('filter.products')}}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        in_stock: in_stock == true ? in_stock : null,
                        out_of_stock: out_of_stock == true ? out_of_stock : null,
                        pre_order: pre_order == true ? pre_order : null,
                        up_coming: up_coming == true ? pre_order : null,
                        category_id:catId,
                        sortBy: sortBy,
                        brands: brands,
                        specifications: specifications,
                        showData: showData
                    },
                    success: function(response) {
                        $('.overlay-loader').hide();
                        $('#product-area').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });

    </script>
@endpush