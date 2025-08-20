@extends('admin.layouts.auth')

@section('title', 'Đặt lại mật khẩu')
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
        <!-- Reset Password -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="{{ route('auth.login') }}" class="app-brand-link gap-2">
                 @include("admin.components.logo")
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Đặt lại mật khẩu  🔒</h4>
            <p class="mb-4">Cho <span class="fw-medium">john.doe@email.com</span></p>
            <form id="formAuthentication" class="mb-3" action="auth-login-basic.html" method="GET">
              @include('admin.modules.auth.showErrors')
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Mật khẩu mới</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="confirm-password">Xác nhận mật khẩu</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="confirm-password" class="form-control" name="confirm-password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100 mb-3">Đặt mật khẩu mới</button>
              <div class="text-center">
                <a href="{{ route('auth.login') }}">
                  <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                  Quay lại đăng nhập
                </a>
              </div>
            </form>
          </div>
        </div>
        <!-- /Reset Password -->
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
