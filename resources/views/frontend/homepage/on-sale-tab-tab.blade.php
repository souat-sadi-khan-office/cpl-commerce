<div class="row">
    <div class="col-12">
        <div class="heading_tab_header">
            <div class="heading_s2">
                <h4>On Sale Products</h4>
            </div>
            <div class="view_all">
                <a href="{{ route('search', ['sort' => 'on-sale']) }}" class="text_default">
                    <span>View All {{ count($products) }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="on-sale-carousel product_list owl-carousel owl-theme nav_style5" data-nav="true" data-dots="false" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "640":{"items": "2"}, "991":{"items": "1"}}'>
            <div class="item">
                @foreach($products as $index => $product)
                    @include('frontend.components.product_main', ['tag' => 'discount_price', 'listing' => 'short'])

                    {{-- <div class="product_wrap">
                        @if (isset($product['discount_type']))
                            <span class="pr_flash bg-success">
                                {{ $product['discount_type'] == 'amount' ? format_price(convert_price($product['discount'])) : $product['discount'] . '%' }} Off
                            </span>
                        @endif
                        <div class="product_img">
                            <a href="shop-product-detail.html">
                                <img src="{{ asset($product['thumb_image']) }}" alt="{{ $product['name'] }}">
                                <img class="product_hover_img" src="{{ asset($product['hover_image']) }}" alt="{{ $product['name'] }}">
                            </a>
                        </div>
                        <div class="product_info">
                            <h6 class="product_title"><a href="shop-product-detail.html">{{ $product['name'] }}</a></h6>
                            <div class="product_price">
                                @if (isset($product['discount_type']))
                                    <span class="price">{{ format_price(convert_price($product['discounted_price'])) }}</span>
                                    <del>{{ format_price(convert_price($product['unit_price'])) }}</del>
                                    <div class="on_sale">
                                        <span>{{ $product['discount_type'] == 'amount' ? format_price(convert_price($product['discount'])) : $product['discount'] . '%' }}
                                            Off</span>
                                    </div>
                                @else
                                    <span class="price">{{ format_price(convert_price($product['unit_price'])) }}</span>
                                @endif
                            </div>
                            <div class="rating_wrap">
                                <div class="rating">
                                    <div class="product_rate" style="width:{{ $product['averageRating'] }}%"></div>
                                </div>
                                <span class="rating_num">({{ $product['ratingCount'] }})</span>
                            </div>
                        </div>
                    </div> --}}
            
                    @if(($index + 1) % 3 == 0)
                        </div><div class="item">
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>