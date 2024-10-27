@extends('frontend.layouts.app', ['title' => 'PC Builder - Build Your Own Computer - '. get_settings('system_name')])

@push('page_meta_information')

    <link rel="canonical" href="{{ route('home') }}" />
    <meta name="referrer" content="origin">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta name="title"
        content="PC Builder - Build Your Own Computer - {{ get_settings('system_name') }}">
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
                            PC Builder
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
<div class="main_content bg_gray py-5">

    <div class="custom-container">
        <div class="pcb-container">
            <div class="pcb-head">
                <div class="startech-logo">
                    <img class="logo" src="{{ asset('pictures/default-logo-dark.png') }}" alt="Logo">
                </div>
                <div class="actions">
                    <div class="all-actions">
                        <a class="action" href="#">
                            <i class="fas fa-shopping-basket"></i>
                            <span class="action-text">Add to Cart</span>
                        </a>
                        <a class="action" href="#">
                            <i class="far fa-save"></i>
                            <span class="action-text">Save PC</span>
                        </a>
                        <a class="action m-hide" href="#">
                            <i class="fas fa-print"></i>
                            <span class="action-text">Print</span>
                        </a>
                        <form action="https://www.startech.com.bd/tool/pc_builder/base64_to_image" target="_blank"
                            method="post" id="form-base64-image">
                            <button type="submit" class="action">
                                <i class="fas fa-camera"></i>
                                <span class="action-text">Screenshot</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
    
            <div class="pcb-inner-content">
                <div class="pcb-top-content">
                    <div class="left">
                        <h1 class="m-hide">PC Builder - Build Your Own Computer - Star Tech</h1>
                        <div class="checkbox-inline">
                            <input type="checkbox" name="hide" id="input-hide">
                            <label for="input-hide">Hide Unconfigured Components</label>
                        </div>
                    </div>
                    <div class="right">
                        <div class="total-amount estimated-watt">
                            <span class="amount">0W</span><br>
                            <span class="items">Estimated Wattage</span>
                            <span class="betaa">BETA</span>
                        </div>
                        <div class="total-amount t-price">
                            <span class="amount">0৳</span><br>
                            <span class="items">0 Items</span>
                        </div>
                    </div>
                </div>
                <div class="pcb-content">
                    <div class="content-label">Core Components</div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico cpu"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>CPU</span><span class="mark">Required</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=2" title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico cpu-cooler"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>CPU Cooler</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=4" title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico motherboard"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Motherboard</span><span class="mark">Required</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=3" title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico ram"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>RAM</span><span class="mark">Required</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=5" title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico storage"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Storage</span><span class="mark">Required</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=6" title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico graphics-card"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Graphics Card</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=7" title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico power-supply"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Power Supply</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=9" title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico casing"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Casing</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=8" title="">Choose</a>
                        </div>
                    </div>
                    <div class="content-label">Peripherals &amp; Others</div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico monitor"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Monitor</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=10"
                                title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico casing-cooler"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Casing Cooler</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=20"
                                title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico keyboard"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Keyboard</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=11"
                                title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico mouse"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Mouse</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=12"
                                title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico anti-virus"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Anti Virus</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=16"
                                title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico headphone"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>Headphone</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=19"
                                title="">Choose</a>
                        </div>
                    </div>
                    <div class="c-item blank">
                        <div class="img">
                            <span class="img-ico ups"></span>
                        </div>
                        <div class="details">
                            <div class="component-name"><span>UPS</span></div>
                            <div class="product-name"></div>
                        </div>
                        <div class="item-price">
                        </div>
                        <div class="actions">
                            <a class="btn st-outline"
                                href="https://www.startech.com.bd/tool/pc_builder/choose?component_id=18"
                                title="">Choose</a>
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
