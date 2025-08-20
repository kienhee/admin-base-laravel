@php
    use Config\Admin;
@endphp
{{-- Core JS --}}
{{-- build:js {{ Admin::asset_admin_url('assets/vendor/js/core.js') }} --}}

<script src="{{ Admin::asset_admin_url('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ Admin::asset_admin_url('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ Admin::asset_admin_url('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ Admin::asset_admin_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ Admin::asset_admin_url('assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ Admin::asset_admin_url('assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ Admin::asset_admin_url('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ Admin::asset_admin_url('assets/vendor/js/menu.js') }}"></script>

{{-- endbuild --}}

{{-- Vendors JS --}}
@yield('vendor-js')
@stack('scripts')
{{-- Main JS --}}
<script src="{{ Admin::asset_admin_url('assets/js/main.js') }}"></script>

{{-- Page JS --}}
@yield('page-js')
<script>$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });</script>
