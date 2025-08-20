

<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="/resources/admin/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title') | {{ env('APP_NAME') }} </title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include("admin.layouts.sections.styles")

</head>

<body>
    {{-- Layout wrapper --}}
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            {{-- Menu --}}
            @include("admin.layouts.sections.menu")
            {{-- / Menu --}}

            {{-- Layout container --}}
            <div class="layout-page">
                {{-- Navbar --}}
                @include("admin.layouts.sections.navbar")
                {{-- / Navbar --}}

                {{-- Content wrapper --}}
                <div class="content-wrapper">
                    {{-- Content --}}
                    <div class="flex-grow-1 container-p-y container-fluid">
                        @yield('content')
                    </div>
                    {{-- / Content --}}

                    {{-- Footer --}}
                    @include('admin.layouts.sections.footer')
                    {{-- / Footer --}}

                    <div class="content-backdrop fade"></div>
                </div>
                {{-- Content wrapper --}}
            </div>
            {{-- / Layout page --}}
        </div>

        {{-- Overlay --}}
        <div class="layout-overlay layout-menu-toggle"></div>

        {{-- Drag Target Area To SlideIn Menu On Small Screens --}}
        <div class="drag-target"></div>
    </div>
    {{-- / Layout wrapper --}}

    @include('admin.layouts.sections.scripts')
</body>

</html>
