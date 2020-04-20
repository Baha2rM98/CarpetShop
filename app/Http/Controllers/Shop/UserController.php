<?php

namespace App\Http\Controllers\Shop;

use App\Address;
use App\Category;
use App\City;
use App\Http\Controllers\Controller;
use App\Product;
use App\Province;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class UserController extends Controller
{
    /**
     * Shows the authenticated user dashboard
     *
     * @return Factory|View
     */
    public function profile()
    {
        $menus = Category::all();
        $user = Auth::user();

        return view('shop.dashboard.index', compact('user', 'menus'));
    }

    /**
     * Shows favorite list of user
     *
     * @param  Request  $request
     * @return View|Factory
     */
    public function getFavorites(Request $request)
    {
        $menus = Category::all();

        $user = $request->user();

        $products = Product::with('photos')->whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->paginate(10);

        return view('shop.dashboard.favorites-list', compact('products', 'menus', 'user'));
    }

    /**
     * Adds products to user's favorite list
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function addToFavorite(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $user = $request->user();

        if ($user->products()->where('product_id', $product->id)->exists()) {
            return back();
        }

        $user->products()->attach([$product->id]);

        return back();
    }

    /**
     * Deletes a product from user's favorite list
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function deleteFromFavorites(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->user()->products()->detach([$product->id]);

        return back()->with(['deleted' => 'محصول مورد نظر از لیست علاقه مندی های شما حذف شد!']);
    }

    /**
     * Shows addresses list of user
     *
     * @param  Request  $request
     * @return View|Factory
     */
    public function getAddresses(Request $request)
    {
        $menus = Category::all();

        $user = $request->user();

        $addresses = Address::with('province', 'city')->where('user_id', $user->id)->paginate(10);

        return view('shop.dashboard.addresses-list', compact('menus', 'addresses', 'user'));
    }

    /**
     * Shows create view of user's address
     *
     * @param  Request  $request
     * @return View|Factory
     */
    public function createAddressView(Request $request)
    {
        $menus = Category::all();

        $user = $request->user();

        $cities = City::all();

        $provinces = Province::all();

        return view('shop.dashboard.address-create', compact('menus', 'user', 'cities', 'provinces'));
    }

    /**
     * Creates a new address for user
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function storeAddress(Request $request)
    {
        $this->addressValidator($request);

        $user = $request->user();
        $primary = $request->input('primary');

        if (Address::where([['user_id', '=', $user->id], ['primary', '=', 1]])->get()->count() === 1 && $primary == 1) {
            return back()->with(['error' => 'شما نمیتوانید بیش از یک آدرس اصلی داشته باشید!']);
        }

        $address = new Address($request->all());
        $address->primary = $primary;
        $address->user_id = $user->id;
        $address->saveOrFail();

        return redirect()->route('address.index')->with(['ok' => 'آدرس جدید شما با موفقیت ذخیره شد!']);
    }

    /**
     * Shows edit view of user's address
     *
     * @param  Request  $request
     * @param  int  $id
     * @return View|Factory
     */
    public function editAddressView(Request $request, $id)
    {
        $menus = Category::all();

        $user = $request->user();

        $cities = City::all();

        $provinces = Province::all();

        $address = Address::with('province', 'city')->findOrFail($id);

        return view('shop.dashboard.address-edit', compact('address', 'menus', 'user', 'cities', 'provinces'));
    }

    /**
     * Updates user's address
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateAddress(Request $request, $id)
    {
        $this->addressValidator($request);

        $user = $request->user();
        $primary = $request->input('primary');

        $address = Address::findOrFail($id);

        if ($address->primary !== 1
            && $primary == 1
            && Address::where([['user_id', '=', $user->id], ['primary', '=', 1]])->get()->count() === 1) {
            return back()->with(['error' => 'شما نمیتوانید بیش از یک آدرس اصلی داشته باشید!']);
        }

        $address->fill($request->all());
        $address->primary = $primary;
        $address->saveOrFail();

        return redirect()->route('address.index')->with(['ok' => 'آدرس شما با موفقیت ویرایش شد!']);
    }

    /**
     * Destroys user's address
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function deleteAddress($id)
    {
        $address = Address::findOrFail($id);

        if ($address->primary === 1) {
            return back()->with(['error' => 'آدرس اصلی شما نمی تواند حذف شود!']);
        }

        $address->delete();

        return redirect()->route('address.index')->with(['ok' => 'آدرس شما با موفقیت حذف شد!']);
    }

    /**
     * Shows edit view of user's address
     *
     * @param  Request  $request
     * @return View|Factory
     */
    public function editProfile(Request $request)
    {
        $menus = Category::all();

        $user = $request->user();

        return view('shop.dashboard.profile-edit', compact('user', 'menus'));
    }

    /**
     * Updates user's data
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateProfile(Request $request)
    {
        $this->profileValidator($request);

        $user = $request->user();
        $user->fill($request->all());
        $user->saveOrFail();

        return redirect()->route('user.dashboard')->with(['success' => 'پروفایل شما با موفقیت به روزرسانی شد!']);
    }

    /**
     * Validates profile data
     *
     * @param  Request  $request
     * @return array
     * @throws ValidationException
     */
    private function profileValidator(Request $request)
    {
        return $this->validate($request, [
            'name' => ['bail', 'required'],
            'last_name' => ['bail', 'required'],
            'phone_number' => ['bail', 'required', 'numeric', 'digits_between:11,11'],
            'national_code' => ['bail', 'required', 'numeric', 'digits_between:10,10']
        ], [
            'name.required' => 'عبارت نام نمیتواند خالی باشد!',
            'last_name.required' => 'عبارت نام خانوادگی نمیتواند خالی باشد!',
            'phone_number.required' => 'عبارت شماره تلفن نمیتواند خالی باشد!',
            'phone_number.numeric' => 'شماره تلفن وارد شده معتبر نیست!',
            'phone_number.digits_between' => 'شماره تلفن وارد شده معتبر نیست!',
            'national_code.required' => 'عبارت کدملی نمیتواند خالی باشد!',
            'national_code.numeric' => 'کد ملی وارد شده معتبر نیست!',
            'national_code.digits_between' => 'کد ملی وارد شده معتبر نیست!'
        ]);
    }

    /**
     * Validates addresses
     *
     * @param  Request  $request
     * @return array
     * @throws ValidationException
     */
    private function addressValidator(Request $request)
    {
        return $this->validate($request, [
            'address' => 'required',
            'post_code' => ['bail', 'required', 'numeric', 'digits_between:10,10'],
            'company' => 'nullable'
        ], [
            'address.required' => 'آدرس را وارد نمایید!',
            'post_code.required' => 'کدپستی را وارد نمایید!',
            'post_code.numeric' => 'کد پستی وارد شده معتبر نیست!',
            'post_code.digits_between' => 'کد پستی وارد شده معتبر نیست!'
        ]);
    }
}
