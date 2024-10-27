@extends('backend.layouts.app')
@section('title', 'Home Page Configuration | frontend')

@section('content')
    <div class="row mt-5">
        <div class="col-lg-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h1 class="h5 mb-0">HomePage Settings</h1>
                    <p>
                        Last Updated by - {{ homepage_setting('last_updated_by') }} at 
                        {{get_system_date(homepage_setting('last_updated_at'))}}
                        {{get_system_time(homepage_setting('last_updated_at'))}}
                    </p>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="bannerSection">Banner Section <span class="text-danger">Necessery</span></label>
                            <div class="form-check form-switch"style=" padding-left: 2.9em!important;">
                                <input data-url="#"
                                    class="form-check-input" type="checkbox" role="switch" name="bannerSection"
                                    id="bannerSection" checked disabled>
                            </div>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="sliderSection">Slider Section <span class="text-danger">*</span></label>
                            <div class="form-check form-switch"style=" padding-left: 2.9em!important;">
                                <input data-url="{{ route('admin.homepage.settings.status', 'sliderSection') }}"
                                    class="form-check-input" type="checkbox" role="switch" name="sliderSection"
                                    id="sliderSection" {{ homepage_setting('sliderSection') == 1 ? 'checked' : '' }}>
                            </div>

                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="midBanner">Mid Banner Section <span class="text-danger">*</span></label>
                            <div class="form-check form-switch"style=" padding-left: 2.9em!important;">
                                <input data-url="{{ route('admin.homepage.settings.status', 'midBanner') }}"
                                    class="form-check-input" type="checkbox" role="switch" name="midBanner" id="midBanner"
                                    {{ homepage_setting('midBanner') == 1 ? 'checked' : '' }}>
                            </div>

                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="dealOfTheDay">Deal of the Day Section <span class="text-danger">*</span></label>
                            <div class="form-check form-switch"style=" padding-left: 2.9em!important;">
                                <input data-url="{{ route('admin.homepage.settings.status', 'dealOfTheDay') }}"
                                    class="form-check-input" type="checkbox" role="switch" name="dealOfTheDay"
                                    id="dealOfTheDay" {{ homepage_setting('dealOfTheDay') == 1 ? 'checked' : '' }}>
                            </div>

                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="trending">Trending Section <span class="text-danger">*</span></label>
                            <div class="form-check form-switch"style=" padding-left: 2.9em!important;">
                                <input data-url="{{ route('admin.homepage.settings.status', 'trending') }}"
                                    class="form-check-input" type="checkbox" role="switch" name="trending" id="trending"
                                    {{ homepage_setting('trending') == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="brands">Brands Section <span class="text-danger">*</span></label>
                            <div class="form-check form-switch"style=" padding-left: 2.9em!important;">
                                <input data-url="{{ route('admin.homepage.settings.status', 'brands') }}"
                                    class="form-check-input" type="checkbox" role="switch" name="brands" id="brands"
                                    {{ homepage_setting('brands') == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="popularANDfeatured">Popular & Featured Section <span
                                    class="text-danger">*</span></label>
                            <div class="form-check form-switch"style=" padding-left: 2.9em!important;">
                                <input data-url="{{ route('admin.homepage.settings.status', 'popularANDfeatured') }}"
                                    class="form-check-input" type="checkbox" role="switch" name="popularANDfeatured"
                                    id="popularANDfeatured"
                                    {{ homepage_setting('popularANDfeatured') == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="newslatter">Newslatter Section <span class="text-danger">*</span></label>
                            <div class="form-check form-switch"style=" padding-left: 2.9em!important;">
                                <input data-url="{{ route('admin.homepage.settings.status', 'newslatter') }}"
                                    class="form-check-input" type="checkbox" role="switch" name="newslatter"
                                    id="newslatter" {{ homepage_setting('newslatter') == 1 ? 'checked' : '' }}>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        // Update section visibility
        $(document).on('change', 'input[type="checkbox"]', function() {
            var status = this.checked ? 1 : 0;
            var url = $(this).data('url');
            var name = $(this).attr('name');

            $.ajax({
                url: url, 
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), 
                    [name]: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message); 
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred while updating the status.');
                }
            });
        });
    </script>
@endpush
