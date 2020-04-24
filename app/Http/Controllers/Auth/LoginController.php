<?php

namespace App\Http\Controllers\Auth;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest', 'throttle:80,1'])->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return Factory|View
     */
    public function showLoginForm()
    {
        $menus = Category::all();

        return view('auth.login', compact('menus'));
    }

    /**
     * Validate the user login request.(Override)
     *
     * @param  Request  $request
     *
     * @return array
     * @throws ValidationException
     */
    protected function validateLogin(Request $request)
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
}
