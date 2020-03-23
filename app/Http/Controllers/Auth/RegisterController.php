<?php

namespace App\Http\Controllers\Auth;

use App\Address;
use App\City;
use App\Http\Controllers\Controller;
use App\Province;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Throwable;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $this->middleware('guest');
    }

    /**
     * Registers a new user into the system
     *
     * @param  Request  $request
     *
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function register(Request $request)
    {
        $this->validator($request);
        $user = new User();
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->national_code = $request->input('national_code');
        $user->password = Hash::make($request->input('password'));
        $user->saveOrFail();
        $address = new Address();
        $address->company = $request->input('company');
        $address->address = $request->input('address');
        $address->post_code = $request->input('post_code');
        $address->province_id = $request->input('province');
        $address->city_id = $request->input('city');
        $address->user_id = $user->id;
        $address->saveOrFail();
        Session::flash('ok', 'ثبت نام با موفقیت انجام شد. لطفا حساب کاربری خود را تاییید نمایید.');

        return redirect('login');
    }

    /**
     * Handles input request for validate
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
            'email' => ['bail', 'required', 'email', 'unique:users'],
            'phone_number' => ['bail', 'required', 'numeric', 'digits_between:11,11'],
            'national_code' => ['bail', 'required', 'numeric', 'digits_between:10,10'],
            'company' => ['bail', 'nullable'],
            'address' => ['bail', 'required'],
            'post_code' => ['bail', 'required', 'numeric', 'digits_between:10,10'],
            'city' => ['bail', 'required'],
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
            'national_code.required' => 'عبارت کدملی نمیتواند خالی باشد!',
            'national_code.numeric' => 'کد ملی وارد شده معتبر نیست!',
            'national_code.digits_between' => 'کد ملی وارد شده معتبر نیست!',
            'address.required' => 'عبارت آدرس نمیتواند خالی باشد!',
            'post_code.required' => 'عبارت کد پستی نمیتواند خالی باشد!',
            'post_code.numeric' => 'کد پستی وارد شده معتبر نیست!',
            'post_code.digits_between' => 'کد پستی وارد شده معتبر نیست!',
            'city.required' => 'شهر و استان نمیتواند خالی باشد!',
            'password.required' => 'عبارت رمز عبور نمیتواند خالی باشد!',
            'password.min' => 'رمز عبور وارد شده نمیتواند کمتر از 8 کاراکتر باشد!',
            'password_confirmation.required' => 'عبارت تایید رمز عبور نمیتواند خالی باشد!',
            'password_confirmation.same' => 'رمز عبور وارد شده با تاییدیه رمز عبور مطابقت ندارد!'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | API Controllers
    |--------------------------------------------------------------------------
    |
    | Here is where we registered API controller for our application
    */

    /**
     * Returns related cities for each province to vue by api
     *
     * @param  int  $provinceId
     *
     * @return JsonResponse
     */
    public function getAllCities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)->get();

        return response()->json(['cities' => $cities], 200);
    }

    /**
     * Returns all provinces to vue by api
     *
     * @return JsonResponse
     */
    public function getAllProvinces()
    {
        $provinces = Province::all();

        return response()->json(['provinces' => $provinces], 200);
    }
}
