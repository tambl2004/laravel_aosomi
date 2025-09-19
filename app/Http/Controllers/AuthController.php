<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng ký
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng ký
     */
    public function register(Request $request)
    {
        // Validation dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Tạo user mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Mặc định là user
        ]);

        // Gửi email xác thực
        event(new Registered($user));

        // Thông báo thành công
        return redirect()->route('login')
            ->with('success', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        // Validation dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Mật khẩu là bắt buộc',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Thông tin đăng nhập
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Thử đăng nhập
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Kiểm tra email đã được xác thực chưa
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Vui lòng xác thực email trước khi đăng nhập.');
            }

            // Chuyển hướng theo role
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('customer.dashboard');
            }
        }

        // Đăng nhập thất bại
        return redirect()->back()
            ->with('error', 'Email hoặc mật khẩu không đúng.')
            ->withInput();
    }

    /**
     * Đăng xuất
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Đăng xuất thành công!');
    }

    /**
     * Xác thực email
     */
    public function verifyEmail(Request $request)
    {
        $userId = $request->route('id');
        $hash = $request->route('hash');
        
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Người dùng không tồn tại.');
        }

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')
                ->with('error', 'Link xác thực không hợp lệ.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('info', 'Email đã được xác thực trước đó.');
        }

        // Đánh dấu email đã được xác thực
        $result = $user->markEmailAsVerified();
        
        if ($result) {
            return redirect()->route('login')
                ->with('success', 'Email đã được xác thực thành công! Bạn có thể đăng nhập.');
        } else {
            return redirect()->route('login')
                ->with('error', 'Có lỗi xảy ra khi xác thực email. Vui lòng thử lại.');
        }
    }

    /**
     * Gửi lại email xác thực
     */
    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('info', 'Email đã được xác thực.');
        }

        $request->user()->sendEmailVerificationNotification();

        return redirect()->back()
            ->with('success', 'Email xác thực đã được gửi lại.');
    }
}