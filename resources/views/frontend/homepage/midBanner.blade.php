<!-- START SECTION BANNER -->
<div class="section pb_20 small_pt">
    <div class="custom-container">
        <div id="midBanner" style="height: 340px" class="row">
            <div class="col-md-4 shimmer">
                <div class="sale-banner mb-3 mb-md-4">
                    <div class="shimmer-image"></div>
                    <div class="shimmer-title"></div>
                </div>
            </div>
            <div class="col-md-4 shimmer">
                <div class="sale-banner mb-3 mb-md-4">
                    <div class="shimmer-image"></div>
                    <div class="shimmer-title"></div>
                </div>
            </div>
            <div class="col-md-4 shimmer">
                <div class="sale-banner mb-3 mb-md-4">
                    <div class="shimmer-image"></div>
                    <div class="shimmer-title"></div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('styles')
    <style>
        #midBanner {
            display: flex;
            flex-wrap: wrap;
        }

        .shimmer {
            position: relative;
            overflow: hidden;
            height: 290px !important;
        }

        .shimmer-image {
            width: 100%;
            height: 250px;
            /* Adjust based on your design */
            background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        .shimmer-title {
            width: 80%;
            height: 20px;
            margin: 10px 0;
            background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: 0 0;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/?mid_banners=1',
                method: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        $('#midBanner').empty();
                        const banners = response.data.mid;
                        let html = '';

                        if (banners.length === 0) {
                            html = '<p>No banners available at this time.</p>';
                        } else {
                            banners.forEach(banner => {
                                html += `
                    <div class="col-md-4">
                        <div class="sale-banner mb-3 mb-md-4">
                            <a class="hover_effect1" href="${banner.link}">
                                <img src="{{ asset('${banner.image}') }}" alt="${banner.alt_tag}">
                                <div class="banner-title text-center">${banner.header_title}</div>
                            </a>
                        </div>
                    </div>
                `;
                            });
                        }

                        // Append the HTML to the #midBanner element
                        $('#midBanner').append(html);
                    } else {
                        console.error('Request failed:', response);
                    }
                },

                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>
@endpush
<!-- END SECTION BANNER -->
