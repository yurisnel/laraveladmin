<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Aplicación de control interno" />
    <meta property="og:url" content="https://newfrontier.cl/" />
    <meta property="og:site_name" content="LaravelAdmin | Adminitración" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url('/') }}/img/logo/favicon.png" />

    <title>{{ config('app.name', 'Administración | LaravelAdmin') }}</title>

    <!-- Fonts -->
    <link href="{{ url('/') }}/metronic/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(usado en la mayoria de las páginas)-->
    <link href="{{ url('/') }}/metronic/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/metronic/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/css/my-styles.css" rel="stylesheet" type="text/css" />

    <script>
        window.themeUrl = "{{ url('/') }}/metronic/";
        window.App = {{ Js::from($appData); }};
    </script>

    <!-- Scripts -->
    <!--@vite(['resources/css/app.css', 'resources/js/app.js'])-->
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default scroll">
    <script src="{{ url('/') }}/js/setup.js"></script>
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header">
                <!--begin::Header container-->
                <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
                    <!--begin::sidebar mobile toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                                    <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <!--end::sidebar mobile toggle-->
                    <!--begin::Mobile logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="../../demo1/dist/index.html" class="d-lg-none">
                            <img alt="Logo" src="{{ url('/') }}/img/logo/logo-light.png" class="h-30px" />
                        </a>
                    </div>
                    <!--end::Mobile logo-->
                    <!--begin::Header wrapper-->
                    @include('modules.header')
                    <!--end::Header wrapper-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                @include('modules.menu')
                <!--end::Sidebar-->
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    @include('modules.alerts')

                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6 row mx-1">
                            <div id="kt_app_toolbar_container" class="app-container d-flex flex-stack">
                                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{$pageTitle}}</h1>
                                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                        @foreach ($breadcrumb as $title=>$link)
                                        @if (!empty($link))
                                        @if (!$loop->first)
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        @endif
                                        <li class="breadcrumb-item text-muted">
                                            <a href="{{$link}}" class="text-muted text-hover-primary">{{$title}}</a>
                                        </li>

                                        @else
                                        <li class="breadcrumb-item text-muted">{{$title}}</li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>

                                @if (isset($actions))
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    {{ $actions }}
                                </div>
                                @endif

                            </div>
                        </div>
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container">
                                {{ $slot }}
                            </div>
                        </div>
                        <!--end::Content wrapper-->
                        <!--begin::Footer-->
                        @include('modules.footer')
                        <!--end::Footer-->
                    </div>
                    <!--end:::Main-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::App-->

        <!--begin::Scrolltop-->
        <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
            <span class="svg-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                    <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Scrolltop-->

        <!--begin::Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="modal-title">My Title</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body">
                    </div>
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal-->



        <!--begin::Javascript-->

        <!--begin::Global Javascript Bundle(usado en la mayoria de las páginas)-->
        <script src="{{ url('/') }}/metronic/plugins/global/plugins.bundle.js"></script>
        <script src="{{ url('/') }}/metronic/js/scripts.bundle.js"></script>
        <!--end::Global Javascript Bundle-->

        <!--begin::Javascript(usado en la mayoria de las páginas)-->
        <script src="{{ url('/') }}/js/jquery.validate.js"></script>
        <script src="{{ url('/') }}/js/localization/messages_es.js"></script>
        <script src="{{ url('/') }}/js/additional-methods.js"></script>
        <script src="{{ url('/') }}/js/jquery.rut.js"></script>
        <!--end::Javascript-->


        <!--begin::Vendors Javascript(usado en la mayoria de las páginas)-->
        <script src="{{ url('/') }}/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
        <!--end::Vendors Javascript-->

        <script src="{{ url('/') }}/js/app.js"></script>

        @if (isset($scripts))
        {{ $scripts }}
        @endif
</body>

</html>