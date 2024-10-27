<div class="row">
    <div class="col-12">
        <div class="heading_tab_header">
            <div class="heading_s2">
                <h4>Trending Products</h4>
            </div>
            <div class="view_all">
                <a href="{{ route('search', ['sort' => 'popularity']) }}" class="text_default">
                    <span>View All {{ count($products) }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="trending-carousel owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>

            @foreach($products as $index => $product)
                <div class="item">
                    @include('frontend.components.product_main', ['tag' => 'discount_price', 'listing' => 'section_wise'])
                </div>
            @endforeach
        </div>
    </div>
</div>