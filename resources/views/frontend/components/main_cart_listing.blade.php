@if (isset($cart_updated) && $cart_updated == 1)
    <div class="alert alert-warning" role="alert">
        <h4>
            <i style="color:#ffaf38;" class="fas fa-exclamation-triangle"></i>
            <b>Important messages about items in your Cart:</b>
        </h4>
        <p class="mb-0 pb-0">Some items in your cart cannot be shipped to your selected delivery location. So for this reason those products are removed from your cart.</p>
    </div>
@endif

@if(count($models) > 0)
    @foreach($models as $model)
        <div class="item">
            <div class="image">
                <img src="{{ $model['thumb_image'] }}" alt="{{ $model['name'] }}" width="47" height="47">
            </div>
            <div class="info">
                <div class="name">
                    {{ $model['name'] }}
                </div>
                <span> {{ format_price(convert_price($model['price'])) }}</span>
                <i class="fas fa-times"></i>
                <span>{{ $model['quantity'] }} </span>
                <span class="eq">=</span>
                <span class="total">{{ format_price(convert_price($model['quantity'] * $model['price'])) }}</span>
            </div>

            <div style="cursor: pointer;" class="remove-item-from-cart text-danger" data-id="{{ $model['id'] }}" data-bs-toggle="tooltip" data-bs-placement="Top" title="Remove">
                <i class="fas fa-trash"></i>
            </div>
        </div>
    @endforeach
@else
    <div class="empty-content">
        <p class="text-center">Your shopping cart is empty!</p>
    </div>
@endif    