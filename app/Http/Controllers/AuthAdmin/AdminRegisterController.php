<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Throwable;

class AdminRegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Shows admin registration form
     *
     * @return View|Factory
     */
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    /**
     * Registers a new admin into the system
     *
     * @param  Request  $request
     *
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function register(Request $request)
    {
        $this->validator($request);

        $admin = new Admin($request->all());
        $admin->password = Hash::make($request->input('password'));
        $admin->saveOrFail();

        Session::flash('ok', 'ثبت نام با موفقیت انجام شد. لطفا حساب کاربری خود را تاییید نمایید.');
        return redirect()->route('admin.login.form');
    }

    /**
     * Handles input request for validation
     *
     * @param  Request  $request
     * @return array
     * @throws ValidationException
     */
    private function validator(Request $request)
    {
        return $this->validate($request, [
            'name' => ['bail', 'required'],
            'last_name' => ['bail', 'required'],
            'email' => ['bail', 'required', 'email', Rule::unique('admins')->whereNull('deleted_at')],
            'phone_number' => ['bail', 'required', 'numeric', 'digits_between:11,11'],
            'password' => ['bail', 'required', 'min:8'],
            'password_confirmation' => ['bail', 'required', 'same:password']
        ], [
            'name.required' => 'عبارت نام نمیتواند خالی باشد!',
            'last_name.required' => 'عبارت نام خانوادگی نمیتواند خالی باشد!',
            'email.required' => 'عبارت ایمیل نمیتواند خالی باشد!',
            'email.email' => 'ایمیل وارد شده معتبر نیست!',
            'email.unique' => 'ایمیل وارد شده قبلا ثبت شده است!',
            'phone_number.required' => 'عبارت شماره تلفن نمیتواند خالی باشد!',
            'phone_number.numeric' => 'شماره تلفن وارد شده معتبر نیست!',
            'phone_number.digits_between' => 'شماره تلفن وارد شده معتبر نیست!',
            'password.required' => 'عبارت رمز عبور نمیتواند خالی باشد!',
            'password.min' => 'رمز عبور وارد شده نمیتواند کمتر از 8 کاراکتر باشد!',
            'password_confirmation.required' => 'عبارت تایید رمز عبور نمیتواند خالی باشد!',
            'password_confirmation.same' => 'رمز عبور وارد شده با تاییدیه رمز عبور مطابقت ندارد!'
        ]);
    }
}
