<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\Factory;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    /**
     * Where to redirect users after login
     *
     * @var string
     */
    private $redirectTo = '/administrator/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware(['guest:admin', 'throttle:80,1'])->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Shows admin registration form
     *
     * @return View|Factory
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handles a login request to the application
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validator($request);
        if ($this->guard()->attempt($request->only('email', 'password'))) {
            return redirect()->intended($this->redirectTo);
        }

        Session::flash('email', 'نام کاربری یا رمز عبور اشتباه است!');
        return redirect()->route('admin.login.form');
    }

    /**
     * Logs out specified admin
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }

    /**
     * Validates input request for logging in
     *
     * @param  Request  $request
     * @return array
     * @throws ValidationException
     */
    private function validator(Request $request)
    {
        return $this->validate($request, [
            'email' => ['bail', 'required', 'email'],
            'password' => ['bail', 'required']
        ], [
            'email.required' => 'آدرس ایمیل نمیتواند خالی باشد!',
            'email.email' => 'آدرس ایمیل وارد شده معتبر نیست!',
            'password.required' => 'رمز عبور نمیتواند خالی باشد!'
        ]);
    }

    /**
     * Get the guard to be used during authentication
     *
     * @return StatefulGuard
     */
    private function guard()
    {
        return Auth::guard('admin');
    }
}
