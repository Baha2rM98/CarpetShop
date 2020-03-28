<?php

namespace App\Http\Controllers\Frontend;

use App\Cart;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Rules\IsCouponCodeValid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CouponController extends Controller
{
    /**
     * Applies coupon for authenticated user
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function applyCoupon(Request $request)
    {
        $this->couponValidator($request);
        if (!$this->userHasCoupon($request)) {
            $coupon = Coupon::where('code', $request->input('code'))->first();
            if (is_null($coupon)) {
                Session::flash('usedCoupon', 'ابتدا کد تخفیف را وارد کنید!');
                return back();
            }
            $cart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($cart);
            $cart->addCoupon($coupon);
            $request->session()->put('cart', $cart);
            $user = Auth::user();
            $user->coupons()->attach([$coupon->id]);
            return back();
        }
        Session::flash('usedCoupon', 'این کد تخفیف قبلا استفاده شده است!');
        return back();
    }

    /**
     * Checks if authenticated user has related coupon
     *
     * @param  Request  $request
     * @return bool
     */
    private function userHasCoupon(Request $request)
    {
        return Auth::user()->whereHas('coupons', function ($query) use ($request) {
            $query->where('code', $request->input('code'));
        })->exists();
    }

    /**
     * Validates input coupon
     *
     * @param  Request  $request
     * @return array
     * @throws ValidationException
     */
    private function couponValidator(Request $request)
    {
        return $this->validate($request, ['code' => ['nullable', new IsCouponCodeValid()]]);
    }
}
