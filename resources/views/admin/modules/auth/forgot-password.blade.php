@extends('admin.layouts.auth')

@section('title', 'Quên mật khẩu')
@section('vendor-css')
    <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/form-validation.css') }}" />
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/css/pages/page-auth.css') }}" />
@endsection
@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ route('auth.login') }}" class="app-brand-link gap-2">
                                 @include("admin.components.logo")
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Quên mật khẩu? 🔒</h4>
                        <p class="mb-4">Nhập email của bạn và chúng tôi sẽ gửi cho bạn hướng dẫn để đặt lại mật khẩu của bạn
                        </p>
                        <form id="formAuthentication" class="mb-3" action="auth-reset-password-basic.html" method="GET">
                            @include('admin.modules.auth.showErrors')
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" autofocus />
                            </div>
                            <button class="btn btn-primary d-grid w-100">Gửi thông tin</button>
                        </form>
                        <div class="text-center">
                            <a href="{{ route('auth.login') }}" class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Quay lại đăng nhập
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>
@endsection
@section('vendor-js')
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
@endsection
@section('page-js')
    @vite(['resources/js/pages/auth.js'])
@endsection
