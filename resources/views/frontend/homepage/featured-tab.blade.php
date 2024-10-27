<div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-autoplay="true" data-margin="20"
    data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
    @foreach ($products as $product)
        <div class="item">
            @include('frontend.components.product_main', ['tag' => 'hot_badge', 'listing' => 'section_wise'])
        </div>
    @endforeach
</div>
    <script>
        $(document).ready(function() {
            $('.carousel_slider').each( function() {
			    var $carousel = $(this);
                $carousel.owlCarousel({
                    dots : $carousel.data("dots"),
                    loop : $carousel.data("loop"),
                    items: $carousel.data("items"),
                    margin: $carousel.data("margin"),
                    mouseDrag: $carousel.data("mouse-drag"),
                    touchDrag: $carousel.data("touch-drag"),
                    autoHeight: $carousel.data("autoheight"),
                    center: $carousel.data("center"),
                    nav: $carousel.data("nav"),
                    rewind: $carousel.data("rewind"),
                    navText: ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>'],
                    autoplay : $carousel.data("autoplay"),
                    animateIn : $carousel.data("animate-in"),
                    animateOut: $carousel.data("animate-out"),
                    autoplayTimeout : $carousel.data("autoplay-timeout"),
                    smartSpeed: $carousel.data("smart-speed"),
                    responsive: $carousel.data("responsive")
                });	
            });
        })
    </script>
