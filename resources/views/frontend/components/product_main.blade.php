@if (isset($listing) && $listing != 'product_details_short')
    <div class="product_wrap {{ isset($listing) && $listing == 'main' ? 'min-height' : '' }}">
        @isset($tag)
            @if ($tag == 'discount_price' && isset($product['discount_type']))
                <span class="pr_flash bg-success">
                    {{ $product['discount_type'] == 'amount' ? format_price(convert_price($product['discount'])) : $product['discount'] . '%' }} Off
                </span>
            @endif

            @if ($tag == 'hot_badge')
                @if ($product['ratingCount'] > 5 && $product['averageRating'] > 80)
                    <span class="pr_flash bg-danger">Hot</span>
                @else
                    <span class="pr_flash">New</span>
                @endif
            @endif
        @endisset
        
        <div class="product_img">
            <a href="{{ route('slug.handle', $product['slug']) }}">
                <img src="{{ asset($product['thumb_image']) }}"
                    alt="thumb_image">
                <img class="product_hover_img"
                    src="{{ asset($product['hover_image']) }}"
                    alt="hover_image">
            </a>
            @if (!isset($listing) || $listing != 'short')
                <div class="product_action_box">
                    <ul class="list_none pr_action_btn">
                        @if ($product['stock_status'] == 'in_stock')
                            <li>
                                <a class="add-to-cart" href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="Top" title="Add to Cart" data-id="{{ $product['slug'] }}">
                                    <i class="fas fa-shopping-bag"></i>
                                </a>
                            </li>
                        @endif
                        
                        <li>
                            <a href="javascript:;" class="add_compare" data-id="{{ $product['slug'] }}" data-bs-toggle="tooltip" data-bs-placement="Top" title="Add to Compare">
                                <i class="fas fa-random"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('quick.view', $product['slug']) }}" class="popup-ajax">
                                <i class="fas fa-search"></i>
                            </a>
                        </li>
                        <li>
                            <a data-id="{{ $product['id'] }}" href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="Top" title="Save to Wish List" class="add_wishlist" >
                                <i class="far fa-heart"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
            
        </div>
        <div class="product_info product-listing">
            <h6 class="product_title">
                <a href="{{ route('slug.handle', $product['slug']) }}">
                    {{ ucwords($product['name']) }}
                </a>
            </h6>
            <div class="product_price">
                @if (isset($product['discount_type']))
                    <span class="price">
                        {{ format_price(convert_price($product['discounted_price'])) }}
                    </span>
                    <del>
                        {{ format_price(convert_price($product['unit_price'])) }}
                    </del>
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
            @if (isset($listing) && $listing == 'main')
                <div class="pr_desc">
                    <ul>
                        @foreach ($product['specifications'] as $features)
                            <li>
                                {{ $features['type_name'] }} : {{ $features['attr_name'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                @if ($product['stage'] != 'normal')
                    <span class="st-btn stock-status">{{ ucfirst($product['stage']) }}</span>
                @endif
                @if ($product['stage'] == 'normal' && $product['stock_status'] == 'in_stock')
                    <span class="st-btn stock-status in-stock-status">In Stock</span>
                @endif
                @if ($product['stock_status'] != 'in_stock')
                    <a href="{{ route('slug.handle', $product['slug']) }}" class="stock-status-warning">See all buying option</a>
                @endif
            @endif
        </div>
    </div>
@else    
    <li>
        <div class="post_img">
            <a href="{{ route('slug.handle', $product['slug']) }}">
                <img src="{{ asset($product['thumb_image']) }}" alt="{{ $product['name'] }}">
            </a>
        </div>
        <div class="post_content">
            <h6 class="product_title">
                <a href="{{ route('slug.handle', $product['slug']) }}">
                    {{ $product['name'] }}
                </a>
            </h6>
            <div class="product_price">
                @if (isset($product['discount_type']))
                    <span class="price">
                        {{ format_price(convert_price($product['discounted_price'])) }}
                    </span>
                    <del>
                        {{ format_price(convert_price($product['unit_price'])) }}
                    </del>
                @else
                    <span class="price">{{ format_price(convert_price($product['unit_price'])) }}</span>
                @endif
            </div>
            <div class="rating_wrap">
                <div class="rating_wrap">
                    <div class="rating">
                        <div class="product_rate" style="width:{{ $product['averageRating'] }}%"></div>
                    </div>
                    <span class="rating_num">({{ $product['ratingCount'] }})</span>
                </div>
            </div>
        </div>
    </li>
@endif