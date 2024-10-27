<!-- START SECTION CLIENT LOGO -->
<div class="section pt-0 small_pb">
	<div class="custom-container">
    	<div class="row">
			<div class="col-md-12">
                <div class="heading_tab_header">
                    <div class="heading_s2">
                        <h4>Top Brands</h4>
                    </div>
                    <div class="view_all">
                        <a href="{{ route('brands') }}" class="text_default"><span>View All</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12" id="brand-section" style="height: 125px !important;">
            	<div class="carousel_slider owl-carousel owl-theme nav_style3" data-dots="false" data-nav="true" data-margin="30" data-loop="true" data-autoplay="true" data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "767":{"items": "4"}, "991":{"items": "5"}, "1199":{"items": "6"}}'>
                	<div class="item" loader-brand>
                        <div class="loader-brand-image"></div>
                    </div>
                	<div class="item loader-brand">
                        <div class="loader-brand-image"></div>
                    </div>
                	<div class="item loader-brand">
                        <div class="loader-brand-image"></div>
                    </div>
                	<div class="item loader-brand">
                        <div class="loader-brand-image"></div>
                    </div>
                	<div class="item loader-brand">
                        <div class="loader-brand-image"></div>
                    </div>
                	<div class="item loader-brand">
                        <div class="loader-brand-image"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION CLIENT LOGO -->

@push('scripts')
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/?brands=1',
            method: 'POST',
            dataType: 'HTML',
            success: function(response) {
                if (response) {
                    $('#brand-section').html(response);

                    $('.brand-slider').each( function() {
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
                } 
            }
        });
    })
</script>
@endpush