@extends('admin.layouts.auth')

@section('title', 'Đăng nhập')
@section('vendor-css')
    <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/form-validation.css') }}" />
@endsection
@section('page-css')
     <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/css/pages/page-auth.css') }}" />
@endsection
@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="{{ route('auth.login') }}" class="app-brand-link gap-2">
                @include("admin.components.logo")
              </a>
            </div>
            <!-- /Logo -->
            <form id="formAuthentication" class="mb-3" action="{{ route('auth.loginHandle') }}" method="POST">
              @csrf
              @include('admin.modules.auth.showErrors')
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
                  placeholder="Enter your email" autofocus />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Mật khẩu</label>
                  <a tabindex="-1" href="{{ route('auth.forgot-password') }}">
                    <small>Quên mật khẩu?</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                  <label class="form-check-label" for="remember"> Nhớ thông tin </label>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Đăng nhập</button>
              </div>
            </form>

            </div>
          </div>
        </div>
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
