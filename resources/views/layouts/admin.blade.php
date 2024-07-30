<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets') }}/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ url('/') }}">
    <meta name="description" content="Most Powerful &amp; Comprehensive Bootstrap 5 Admin Dashboard built for developers!" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('public/assets/img/favicon/favicon.ico') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/assets/img/favicon/favicon-16x16.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

      <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/fonts/flag-icons.css') }}" />

    {{-- Boxicons --}}
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/fonts/boxicons.css') }}" />

    {{-- Core CSS --}}
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('public/assets/css/demo.css') }}" />

    {{-- Vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" /> --}}
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}" />

    {{-- Page CSS --}}
    @yield('styles')

    {{-- Helpers --}}
    <script src="{{ asset('public/assets/vendor/js/helpers.js') }}"></script>
    {{-- <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script> --}}
    <script src="{{ asset('public/assets/js/config.js') }}"></script>

</head>

<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            {{-- Menu --}}
            @include('partials.menu')
            {{-- Menu --}}

            <!-- Layout container -->
            <div class="layout-page">

                {{-- Navbar --}}
                @include('partials.navbar')
                {{-- Navbar --}}

                {{-- Content Wrapper --}}
                <div class="content-wrapper">

                    {{-- Content --}}
                    @yield('content')
                    {{-- Content --}}

                    {{-- Footer --}}
                    @include('partials.footer')
                    {{-- Footer --}}

                    <div class="content-backdrop fade"></div>
                </div>
                {{-- Content Wrapper --}}

            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    {{-- Core JS --}}
    <script src="{{ asset('public/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('public/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/libs/select2/select2.js') }}"></script>

    {{-- <script src="{{ asset('public/assets/vendor/libs/toastr/toastr.js') }}"></script> --}}
    <script src="{{ asset('public/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <!-- Page JS -->
    {{-- <script src="{{ asset('public/assets/js/docs.js') }}"></script>
    <script src="{{ asset('public/assets/js/ui-toasts.js') }}"></script> --}}

    <!-- Main JS -->
    <script src="{{ asset('public/assets/js/main.js') }}"></script>
    <!-- Common JS -->
    <script src="{{ asset('public/js/common.js') }}"></script>

    {{-- Page JS --}}
    @yield('scripts')

    <!-- Place this tag in your head or just before your close body tag. -->
    {{-- <script async defer src="{{ asset('public/assets/vendor/libs/github/github.min.js') }}"></script> --}}
</body>

</html>
