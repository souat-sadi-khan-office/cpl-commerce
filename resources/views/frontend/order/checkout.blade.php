@extends('frontend.layouts.app', ['title' => 'Checkout'])

@push('page_meta_information')
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta property="og:site_name" content="{{ get_settings('system_name') }}">
@endpush

@push('breadcrumb')
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Checkout</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
@endpush

@section('content')
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    @if (Auth::guard('customer')->check())
                        <div class="col-lg-8 mx-auto">
                            <div class="toggle_info">
                                <span id="copoun-show-area">
                                    <i class="fas fa-tag"></i>
                                    Have a coupon? 
                                    <a href="#coupon" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">Click here to enter your code</a>
                                </span>
                            </div>
                            <div class="panel-collapse collapse coupon_form" id="coupon">
                                <div class="panel-body">
                                    <p>If you have a coupon code, please apply it below.</p>
                                    <div class="coupon field_form input-group">
                                        <input type="text" value="" id="coupon_code" class="form-control" placeholder="Enter Coupon Code..">
                                        <div class="input-group-append">
                                            <button class="btn btn-fill-out btn-sm" id="coupon_submit" style="display:none;" type="button">Apply Coupon</button>
                                            <button class="btn btn-dark btn-block" id="coupon_submitting" type="button">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else 
                        <div class="col-lg-8 mx-auto">
                            <span>
                                <i class="fas fa-tag"></i>
                                Want to apply a coupon? 
                                <a href="{{ route('login') }}">Login to apply your coupon</a>
                            </span>
                        </div>
                    @endif
                    
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="medium_divider"></div>
                        <div class="divider center_icon">
                            <i class="linearicons-credit-card"></i>
                        </div>
                        <div class="medium_divider"></div>
                    </div>
                </div>
                <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="coupon_code" id="ori_coupon_code" value="">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="heading_s1">
                                <h4>Billing Details</h4>
                            </div>
                            <div class="form-group mb-3">
                                @if (isset($userInfo['addresses']) && count($userInfo['addresses']) > 0)
                                    <div class="custom_select" id="addressSelect">
                                        <select class="form-control">
                                            <option value="" disabled selected>Select Saved Details</option>
                                            @foreach ($userInfo['addresses'] as $address)
                                                <option value="{{ $address['id'] }}" data-option={{ $address['id'] }}>
                                                    {{ $address['address'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" required class="form-control" value="{{ $userInfo['name'] }}"
                                    name="customer_name" placeholder="Name *">
                            </div>
                            <div class="form-group mb-3">
                                <input type="email" required class="form-control" value="{{ $userInfo['email'] }}"
                                    name="customer_email" placeholder="Email *">
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" required class="form-control"
                                    value="{{ @$userInfo['phones']->phone_number }}" name="customer_phone"
                                    placeholder="Phone *">
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" value="" name="customer_company"
                                    placeholder="Company Name(if have) *">
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" required class="form-control"
                                    value="{{ auth()->guard('customer')->user()->name }}" name="customer_name"
                                    placeholder="First name *">
                            </div>
                            <div class="form-group mb-3">

                                <input type="text" name="billing_country" class="form-control" value="{{$countryName}}"
                                    disabled>
                                    
                            </div>

                            <div class="form-group mb-3">
                                <div class="custom_select">
                                    <select class="form-control" name="billing_city">
                                        <option value="" disabled selected>Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <input class="form-control" required type="text" name="billing_area"
                                    placeholder="State / County *">
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" name="billing_address" required
                                    placeholder="Address *">
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" name="billing_address2"
                                    placeholder="Address line2">
                            </div>

                            <div class="ship_detail">
                                <div class="form-group mb-3">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox"
                                                name="different_shipping_address" id="differentaddress">
                                            <label class="form-check-label label_info" for="differentaddress"><span>Ship
                                                    to a different address?</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="different_address">
                                    <div class="form-group mb-3">

                                        <input type="text" name="country" class="form-control" value="{{$countryName}}"
                                            disabled>
                                            <input type="hidden" name="country_name" class="form-control" value="{{$countryName}}">
                                            <input type="hidden" name="country_id" class="form-control" value="{{$countryID}}">

                                    </div>

                                    <div class="form-group mb-3">

                                        <div class="custom_select">
                                            <select class="form-control" name="shipping_city">
                                                <option value="" disabled selected>Select City</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group mb-3">
                                        <input class="form-control" type="text" name="shipping_area"
                                            placeholder="State / County *">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="shipping_address"
                                            placeholder="Address *">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="shipping_address2"
                                            placeholder="Address line2">
                                    </div>
                                </div>
                            </div>
                            <div class="heading_s1">
                                <h4>Additional information</h4>
                            </div>
                            <div class="form-group mb-0">
                                <textarea rows="5" class="form-control" placeholder="Order notes"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="order_review">
                                <div class="heading_s1">
                                    <h4>Your Orders</h4>
                                </div>
                                <div class="table-responsive order_table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sub_total = 0;
                                            @endphp
                                            @if (count($models) > 0)
                                                @foreach ($models as $key => $model)
                                                    @php
                                                        $sub_total += ($model['price'] * $model['quantity']);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $model['name'] }} <span class="product-qty">x {{ $model['quantity'] }}</span></td>
                                                        <td>{{ format_price(convert_price($model['price'] * $model['quantity'])) }}</td>
                                                        <input type="hidden" name="product[{{ $key }}][slug]" value="{{ $model['slug'] }}">
                                                        <input type="hidden" name="product[{{ $key }}][qty]" value="{{ $model['quantity'] }}">
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>SubTotal</th>
                                                <td class="product-subtotal">{{ format_price(convert_price($sub_total)) }}</td>
                                            </tr>

                                            <tr>
                                                <th>Shipping</th>
                                                <td class="text-danger left">+ {{ format_price(convert_price($shipping_charge)) }}</td>
                                                <input type="hidden" name="shipping_charge" value="{{ convert_price($shipping_charge) }}">
                                            </tr>

                                            <tr>
                                                <th>Tax Total</th>
                                                <td class="text-danger left">+ {{ format_price(convert_price($tax_amount)) }}</td>
                                                <input type="hidden" name="total_tax" value="{{ convert_price($tax_amount) }}">
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td class="text-success left">- 
                                                    <span id="discount_amount_show">$0.00</span>
                                                </td>
                                                <input type="hidden" name="discount" id="discount_amount_main" value="0">
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td class="product-subtotal" id="product-total">{{ format_price(convert_price($total_price)) }} </td>
                                                <input type="hidden" name="totalAmount" id="totalAmount" value="{{ convert_price($total_price) }}">
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="payment_method">
                                    <div class="heading_s1">
                                        <h4>Payment</h4>
                                    </div>
                                    <div class="payment_option">
                                        <div class="custome-radio">
                                            <input class="form-check-input" type="radio" name="payment_option"
                                                id="exampleRadios5" value="paypal" checked>
                                            <label class="form-check-label" for="exampleRadios5">Paypal</label>
                                            <p data-method="paypal" class="payment-text">Pay via PayPal; you can pay with
                                                your credit card if you don't have a PayPal account.</p>
                                        </div>
                                        <div class="custome-radio">
                                            <input class="form-check-input" type="radio" name="payment_option"
                                                id="exampleRadios4" value="cash_on_delivery">
                                            <label class="form-check-label" for="exampleRadios4">Cash on Delivery</label>
                                            <p data-method="cash_on_delivery" class="payment-text"> You Have to Pay
                                                Delivery Charge
                                                First. </p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="currency_code" value="{{$currencyCode}}">
                                <button type="submit" class="btn btn-fill-out btn-block">Place Order</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- END SECTION SHOP -->

        @include('frontend.homepage.newslatter')
    </div>
@endsection
@push('styles')
    <style>
        .left {
            padding-left: 0px !important;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            _newsletterFormValidation();

            $('#coupon_submitting').hide();
            $('#coupon_submit').show();

            $(document).on('click', '#coupon_submit', function() {
                let couponField = $('#coupon_code');
                if (!couponField.length) {
                    toastr.error('Error: Coupon code input field not found.');
                    return false;
                }

                let coupon_code = $('#coupon_code').val().trim();
                if (coupon_code === undefined || coupon_code === '') {
                    toastr.warning('Warning: Please enter a coupon code.');
                    return false;
                }

                $('#coupon_submitting').show();
                $('#coupon_submit').hide();

                $.ajax({
                    url: '/coupon/check',
                    type: 'POST',
                    data: {
                        coupon: coupon_code
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        if (!data.status) {
                            if(data.validator) {
                                for (const [key, messages] of Object.entries(data.message)) {
                                    messages.forEach(message => {
                                        toastr.warning(message);
                                    });
                                }
                            } else {
                                toastr.warning(data.message);
                            }
                        } else {
                            toastr.success(data.message);

                            $('.coupon_form').hide();
                            $('#copoun-show-area').addClass('text-success');
                            $('#copoun-show-area').html('<i class="fas fa-tag"></i> <b>'+ coupon_code +'</b> coupon is added.');
                            $('#product-total').html(data.total_amount);
                            $('#discount_amount_show').html(data.formatted_amount);
                            $('#discount_amount_main').val(data.amount);
                            $('#ori_coupon_code').val(coupon_code);
                        }

                        $('#coupon_submitting').hide();
                        $('#coupon_submit').show();
                    },
                    error: function(data) {
                        var jsonValue = $.parseJSON(data.responseText);
                        const errors = jsonValue.errors;
                        if (errors) {
                            var i = 0;
                            $.each(errors, function(key, value) {
                                const first_item = Object.keys(errors)[i]
                                const message = errors[first_item][0];
                                if ($('#' + first_item).length > 0) {
                                    $('#' + first_item).parsley().removeError(
                                        'required', {
                                            updateClass: true
                                        });
                                    $('#' + first_item).parsley().addError(
                                        'required', {
                                            message: value,
                                            updateClass: true
                                        });
                                }
                                toastr.error(value);
                                i++;

                            });
                        } else {
                            toastr.warning(jsonValue.message);
                        }

                        $('#coupon_submitting').hide();
                        $('#coupon_submit').show();
                    }
                });

            })

            $('#addressSelect select').on('change', function() {
                const addressId = $(this).val();

                $.ajax({
                    url: '/order/get_address/' + addressId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            const address = response.address;

                            $('input[name="customer_name"]').val(address.first_name + ' ' +
                                address.last_name);
                            $('input[name="customer_company"]').val(address.company_name);
                            $('select[name="billing_city"]').val(address.city_id);
                            $('input[name="billing_area"]').val(address.area);
                            $('input[name="billing_address"]').val(address.address);
                            $('input[name="billing_address2"]').val(address.address_line_2 ||
                                '');
                        } else {
                            alert('Failed to load address details.');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('An error occurred while fetching address details.');
                    }
                });
            });
        });
        
    </script>
@endpush
