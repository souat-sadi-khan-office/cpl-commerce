<head>

    @include('frontend.layouts.partials.seo')

    @stack('meta')

    <!-- Required CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/bootstrap/css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/select2.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('backend/assets/css/parsley.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/toastr.min.css') }}">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    
    {{-- @if (request()->routeIs('home')||request()->routeIs('quick.view')) --}}
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/owlcarousel/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/owlcarousel/css/owl.theme.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/owlcarousel/css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick-theme.css') }}">
    {{-- @endif --}}
    <!-- Optional CSS -->

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">

    @stack('styles')

</head>
