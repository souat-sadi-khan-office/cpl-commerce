@include('backend.layouts.partials.head')
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        @include('backend.layouts.partials.navbar')
        @include('backend.layouts.partials.sidebar')


        <main class="app-main">
            @if (View::hasSection('page_name'))
                @yield('page_name')
            @endif

            <div class="app-content">
                <div class="container-fluid">

                    @yield('content')

                </div>
            </div>
        </main>
        @include('backend.layouts.partials.footer')

    </div>

    @if(isset($modal))
        <div id="modal_remote" class="modal fade border-top-success rounded-top-0" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-{{ $modal }} modal-dialog-centered">
                <div class="modal-content">
                    
                </div>
            </div>
        </div>
    @endif

    @include('backend.components.scripts')
    @stack('script')
</body>
</html>