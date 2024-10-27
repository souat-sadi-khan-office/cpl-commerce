@php
    $main_categories = App\Models\Category::with('children')
    ->where('status', 1)
    ->where('is_featured', 1)
    ->where('parent_id', null)
    ->orderBy('id', 'ASC')
    ->get();
@endphp
<!DOCTYPE html>
<html lang="en">
@include('frontend.layouts.partials.head')

<body>
    @if (Request::is('/'))
        <input type="hidden" id="isHomePage" value="1">
    @else   
        <input type="hidden" id="isHomePage" value="0">
    @endif
    {{-- @include('frontend.layouts.partials.preloader') --}}
    {{-- @include('frontend.components.popup') --}}
    <!-- START HEADER -->
    <header class="header_wrap fixed-top header_with_topbar ">
        @include('frontend.layouts.partials.topbar')
        @include('frontend.layouts.partials.topnav')
        
        @include('frontend.layouts.partials.navbar')
    </header>
    <!-- END HEADER-->
    @stack('breadcrumb')

    @yield('content')

    @include('frontend.layouts.partials.footer')

    @include('frontend.layouts.partials.footerlinks')
    
    <div class="overlay-loader"></div>
</body>

</html>
