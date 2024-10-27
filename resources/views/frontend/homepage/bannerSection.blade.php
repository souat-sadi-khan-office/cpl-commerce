<!-- START SECTION BANNER -->
<div class="mt-4 staggered-animation-wrap">
    <div class="custom-container">
        <div class="row">
            <div class="col-lg-7 offset-lg-3">
                <div class="banner_section shop_el_slider">
                    <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow"
                        data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @if (count($banners))
                                @foreach ($banners['main'] as $index => $carousel)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }} background_bg" data-img-src="{{ asset($carousel->image) }}">
                                        <div class="banner_slide_content banner_content_inner">
                                            <div class="col-lg-7 col-10">
                                                <div class="banner_content3 overflow-hidden">
                                                    <h5 class="mb-3 staggered-animation font-weight-light text-white" data-animation="slideInLeft" data-animation-delay="0.5s" style="z-index: 2">
                                                        {{ @$carousel->header_title }}</h5>
                                                    <h2 class="staggered-animation text-white" data-animation="slideInLeft" data-animation-delay="1s" style="z-index: 2">
                                                        {{ @$carousel->name }}
                                                    </h2>
                                                    <h4 class="staggered-animation mb-4 product-price" data-animation="slideInLeft" data-animation-delay="1.2s">
                                                        <span class="price" style="z-index: 2">{{ @$carousel->old_offer }}</span><del>{{ @$carousel->new_offer }}</del>
                                                    </h4>
                                                    <a class="btn btn-fill-out btn-radius staggered-animation text-uppercase"
                                                        href="{{ $carousel->link }}" data-animation="slideInLeft"
                                                        data-animation-delay="1.5s"style="z-index: 2">Shop Now</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="overlay"></div>
                                    </div>
                                @endforeach
                            @endif
                            
                        </div>
                        
                        <ol class="carousel-indicators indicators_style3">
                            <li data-bs-target="#carouselExampleControls" data-bs-slide-to="0" class="active"></li>
                            <li data-bs-target="#carouselExampleControls" data-bs-slide-to="1"></li>
                            <li data-bs-target="#carouselExampleControls" data-bs-slide-to="2"></li>
                            @if (count($banners['main']) >= 4)
                                <li data-bs-target="#carouselExampleControls" data-bs-slide-to="3"></li>
                                <li data-bs-target="#carouselExampleControls" data-bs-slide-to="4"></li>
                                <li data-bs-target="#carouselExampleControls" data-bs-slide-to="5"></li>
                                @if (count($banners['main']) >= 7)
                                    <li data-bs-target="#carouselExampleControls" data-bs-slide-to="6"></li>
                                    <li data-bs-target="#carouselExampleControls" data-bs-slide-to="7"></li>
                                    <li data-bs-target="#carouselExampleControls" data-bs-slide-to="8"></li>
                                @endif
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
            @if (isset($banners['main_sidebar']) && !$banners['main_sidebar']->isEmpty())
                @php
                    $main_sidebar = $banners['main_sidebar']->shuffle();
                @endphp
                <div class="col-lg-2 d-none d-lg-block">
                    @if (isset($main_sidebar[0]))
                        <div class="shop_banner2 el_banner1">
                            <a href="{{ $main_sidebar[0]->link }}" class="hover_effect1">
                                <div class="el_title text_white">
                                    <h6>{{ $main_sidebar[0]->name }}</h6>
                                    <span>{{ $main_sidebar[0]->new_offer ? $main_sidebar[0]->new_offer . ' off' : '' }}</span>
                                </div>
                                <div class="el_img">
                                    <img src="{{ asset($main_sidebar[0]->image) }}" alt="{{ $main_sidebar[0]->alt_tag }}">
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (isset($main_sidebar[1]))
                        <div class="shop_banner2 el_banner2">
                            <a href="{{ $main_sidebar[1]->link }}" class="hover_effect1">
                                <div class="el_title text_white">
                                    <h6>{{ $main_sidebar[1]->name }}</h6>
                                    <span><u>Shop Now</u></span>
                                </div>
                                <div class="el_img">
                                    <img src="{{ asset($main_sidebar[1]->image) }}"
                                        alt="{{ $main_sidebar[1]->alt_tag }}">
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
<!-- END SECTION BANNER -->

@push('styles')
<style>
    .carousel-item {
        position: relative;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgb(0 0 0 / 7%);
    }

    .banner_slide_content {
        position: relative;
        z-index: 2;
    }
</style>
@endpush
