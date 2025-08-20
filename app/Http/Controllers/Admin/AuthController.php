<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::user()) {
            return redirect()->route('admin.dashboard.analytics');
        }
        // Lưu callback parameter vào session để sử dụng sau khi đăng nhập
        if ($request->has('callback')) {
            $request->session()->put('login_callback', $request->get('callback'));
        }

        return view('admin.modules.auth.login');
    }

    public function loginHandle(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Kiểm tra có callback không để redirect về trang ban đầu
            $callback = $request->session()->pull('login_callback');
            if ($callback) {
                // Chuyển callback từ format admin-dashboard về admin/dashboard
                $redirectPath = '/' . str_replace('-', '/', $callback);
                return redirect($redirectPath);
            }

            return redirect()->route('admin.dashboard.analytics');
        }

        return back()->withErrors([
            'password' => 'Tài khoản hoặc mật khẩu không chính xác.',
        ])->onlyInput('password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }

    public function forgotPassword(Request $request)
    {
        // Handle forgot password logic here
        return view('admin.modules.auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        // Handle reset password logic here
        return view('admin.modules.auth.reset-password');
    }
}
