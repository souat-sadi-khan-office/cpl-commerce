<!-- START SECTION SHOP -->
<div class="section pt-0 pb-0">
    <div class="custom-container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading_tab_header">
                    <div class="heading_s2">
                        <h4>Flash Deals</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="Flash_Deals">
                <div class="product_slider carousel_slider owl-carousel owl-theme nav_style3" data-loop="true"
                    data-dots="false" data-nav="true" data-margin="30"
                    data-responsive='{"0":{"items": "1"}, "650":{"items": "2"}, "1199":{"items": "2"}}'>
                    @for ($i = 0; $i < 4; $i++)
                        <!-- Adjust the number of placeholders as needed -->
                        <div class="item pre-loader">
                            <div class="deal_wrap">
                                <div class="product_img">
                                    <div class="pre-loader-image"></div>
                                </div>
                                <div class="deal_content">
                                    <div class="product_info">
                                        <div class="pre-loader-title"></div>
                                        <div class="pre-loader-price"></div>
                                    </div>
                                    <div class="deal_progress">
                                        <div class="pre-loader-stock"></div>
                                        <div class="pre-loader-stock"></div>
                                        <div class="pre-loader-progress-bar"></div>
                                    </div>
                                    <div class="countdown_time countdown_style4 mb-4"">
                                        <div class="countdown_box">
                                            <div class="countdown-wrap">
                                                <span class="countdown days">00</span>
                                                <span class="cd_text">Days</span>
                                            </div>
                                        </div>
                                        <div class="countdown_box">
                                            <div class="countdown-wrap">
                                                <span class="countdown hours">00</span>
                                                <span class="cd_text">Hours</span>
                                            </div>
                                        </div>
                                        <div class="countdown_box">
                                            <div class="countdown-wrap">
                                                <span class="countdown minutes">00</span>
                                                <span class="cd_text">Minutes</span>
                                            </div>
                                        </div>
                                        <div class="countdown_box">
                                            <div class="countdown-wrap">
                                                <span class="countdown seconds">00</span>
                                                <span class="cd_text">Seconds</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .pre-loader-loader {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }


        .pre-loader {

            background: #f6f7f8;
            /* Light background */
            position: relative;
            overflow: hidden;
            border-radius: 4px;
            /* Rounded corners */
        }

        .pre-loader-image {
            /* Adjust based on your image height */
            background: linear-gradient(90deg, #f6f7f8 25%, #e0e0e0 50%, #f6f7f8 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        .pre-loader-title,
        .pre-loader-price,
        .pre-loader-stock {
            height: 20px;
            /* Adjust height */
            background: #e0e0e0;
            margin: 10px 0;
            border-radius: 4px;
        }

        .pre-loader-title {
            width: 60%;
            /* Adjust width */
        }

        .pre-loader-price {
            width: 40%;
            /* Adjust width */
        }

        .pre-loader-progress-bar {
            height: 8px;
            background: #e0e0e0;
            border-radius: 4px;
            margin-top: 10px;
        }

        @keyframes shimmer {
            0% {
                background-position: -200px 0;
            }

            100% {
                background-position: 200px 0;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/?flash_deals=1',
                method: 'POST',
                dataType: 'HTML',
                success: function(response) {
                    if (response) {

                        $('#Flash_Deals').html(response);
                        $('.flash_deal_slider').each(function() {
                            var $carousel = $(this);

                            $carousel.owlCarousel({
                                dots: $carousel.data("dots"),
                                loop: $carousel.data("loop"),
                                items: $carousel.data("items"),
                                margin: $carousel.data("margin"),
                                mouseDrag: $carousel.data("mouse-drag"),
                                touchDrag: $carousel.data("touch-drag"),
                                autoHeight: $carousel.data("autoheight"),
                                center: $carousel.data("center"),
                                nav: $carousel.data("nav"),
                                rewind: $carousel.data("rewind"),
                                navText: ['<i class="ion-ios-arrow-left"></i>',
                                    '<i class="ion-ios-arrow-right"></i>'
                                ],
                                autoplay: $carousel.data("autoplay"),
                                animateIn: $carousel.data("animate-in"),
                                animateOut: $carousel.data("animate-out"),
                                autoplayTimeout: $carousel.data("autoplay-timeout"),
                                smartSpeed: $carousel.data("smart-speed"),
                                responsive: $carousel.data("responsive")
                            });
                        })

                        $('.countdown_time').each(function() {
                            var endTime = new Date($(this).data('time')).getTime();

                            var countdownInterval = setInterval(() => {
                                var now = new Date().getTime();
                                var distance = endTime - now;

                                // Time calculations
                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 *
                                    24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) /
                                    (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) /
                                    1000);

                                // Update the countdown elements
                                $(this).find('.days').text(days < 10 ? '0' + days :
                                    days);
                                $(this).find('.hours').text(hours < 10 ? '0' + hours :
                                    hours);
                                $(this).find('.minutes').text(minutes < 10 ? '0' +
                                    minutes : minutes);
                                $(this).find('.seconds').text(seconds < 10 ? '0' +
                                    seconds : seconds);

                                // If the countdown is finished
                                if (distance < 0) {
                                    clearInterval(countdownInterval);
                                    $(this).html(
                                    "<span class='cd_text'>EXPIRED</span>");
                                }
                            }, 1000);
                        });


                    } else {
                        console.error('No response received.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    // Optional: Display an error message in the UI
                    $('#Flash_Deals').html(
                        '<p>Failed to load flash deals. Please try again later.</p>');
                }
            });
        });
    </script>
@endpush
<!-- END SECTION SHOP -->
