<?php

namespace App\Http\Controllers\Backend;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCouponRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Throwable;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $coupons = Coupon::paginate(10);

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCouponRequest  $request
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(CreateCouponRequest $request)
    {
        (new Coupon($request->all()))->saveOrFail();
        Session::flash('coupons', 'کد تخفیف جدید با موفقیت ذخیره شد!');

        return redirect()->route('coupons.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateCouponRequest  $request
     * @param  int  $id
     * @return RedirectResponse|Redirector
     */
    public function update(CreateCouponRequest $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->fill($request->all());
        $coupon->saveOrFail();
        Session::flash('coupons', 'کد تخفیف با موفقیت ویرایش شد!');

        return redirect()->route('coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        Session::flash('coupons', 'کد تخفیف با موفقیت حذف شد!');

        return redirect()->route('coupons.index');
    }
}
