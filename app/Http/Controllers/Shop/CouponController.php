<?php

namespace App\Http\Controllers\Shop;

use App\Cart;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Rules\IsCouponCodeValid;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CouponController extends Controller
{
    /**
     * @var bool Number of coupon applies for each order
     */
    private $isFirstOrder = true;

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
        $user = $request->user();
        $session = $request->session();

        if ($session->get($user->email) === false){
            return back()->with(['usedCoupon' => 'شما مجاز به استفاده بیش از 1 کد تخفیف در هر سفارش نمی باشید!']);
        }

        if (!$this->userHasCoupon($request)) {

            $coupon = Coupon::where('code', $request->input('code'))->first();
            if (is_null($coupon)) {
                Session::flash('usedCoupon', 'ابتدا کد تخفیف را وارد کنید!');
                return back();
            }

            $this->isFirstOrder = false;
            $session->put($user->email, $this->isFirstOrder);
            $cart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($cart);
            $cart->addCoupon($coupon);
            $session->put('cart', $cart);
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
        return User::with('coupons')->whereId($request->user()->id)
            ->whereHas('coupons', function ($query) use ($request) {
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
