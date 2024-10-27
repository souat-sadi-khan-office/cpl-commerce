<!-- START SECTION SLIDERS -->
<div class="section small_pt pb-0">
    <div class="custom-container">
        <div class="row">
            <div class="col-xl-3 d-none d-xl-block">
                <div class="sale-banner">
                    <a class="hover_effect1" href="javascript:;">
                        <img src="{{ asset('frontend/assets/images/shop_banner_img6.jpg') }}" alt="shop_banner_img6">
                    </a>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-12">
                        <div class="heading_tab_header">
                            <div class="heading_s2">
                                <h4>Exclusive Products</h4>
                            </div>
                            <div class="tab-style2">
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#tabmenubar" aria-expanded="false">
                                    <span class="ion-android-menu"></span>
                                </button>
                                <ul class="nav nav-tabs justify-content-center justify-content-md-end" id="tabmenubar" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="arrival-tab" data-bs-toggle="tab" href="#arrival" role="tab" aria-controls="arrival" aria-selected="true">
                                            New Arrival
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="sellers-tab" data-bs-toggle="tab" href="#sellers" role="tab" aria-controls="sellers" aria-selected="false">
                                            Best Sellers
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="featured-tab" data-bs-toggle="tab" href="#featured" role="tab" aria-controls="featured" aria-selected="false">
                                            Featured
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="special-tab" data-bs-toggle="tab" href="#special" role="tab" aria-controls="special" aria-selected="false">
                                            Special Offer
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="tab_slider">
                            <div class="tab-pane fade show active" id="arrival" role="tabpanel"
                                aria-labelledby="arrival-tab">
                                <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1"
                                    data-loop="true" data-margin="20" data-autoplay="true"
                                    data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                    @foreach ($newProducts as $product)
                                        <div class="item">
                                            @include('frontend.components.product_main', ['tag' => 'hot_badge', 'listing' => 'section_wise'])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                          

                            <div class="tab-pane fade" id="sellers" role="tabpanel" aria-labelledby="sellers-tab">

                            </div>
                            <div class="tab-pane fade" id="featured" role="tabpanel"
                                aria-labelledby="featured-tab">

                            </div>
                            <div class="tab-pane fade" id="special" role="tabpanel" aria-labelledby="special-tab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#sellers-tab').on('click', function() {
                // Send an AJAX request to the home route with seller parameter
                $.ajax({
                    url: '/?best_seller=1',
                    method: 'POST',
                    dataType: 'HTML',
                    success: function(response) {
                        if (response) {

                            $('#sellers').html(response);
                            // carousel_slider();
                        } else {
                            console.error('Request failed:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            $('#featured-tab').on('click', function() {
                // Send an AJAX request to the home route with seller parameter
                $.ajax({
                    url: '/?featured=1',
                    method: 'POST',
                    dataType: 'HTML',
                    success: function(response) {
                        if (response) {

                            $('#featured').html(response);
                            // carousel_slider();
                        } else {
                            console.error('Request failed:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
            $('#special-tab').on('click', function() {
                // Send an AJAX request to the home route with seller parameter
                $.ajax({
                    url: '/?offred=1',
                    method: 'POST',
                    dataType: 'HTML',
                    success: function(response) {
                        if (response) {

                            $('#special').html(response);
                            // carousel_slider();
                        } else {
                            console.error('Request failed:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endpush
<!-- END SECTION SLIDERS -->
