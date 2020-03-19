<?php

namespace App\Http\Controllers\Auth;

use App\City;
use App\Http\Controllers\Controller;
use App\Province;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;

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
        if ( ! $this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
        $this->middleware('guest');
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
