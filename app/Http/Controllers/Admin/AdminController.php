<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Order;
use App\User;
use App\Admin;
use App\Comment;

class AdminController extends Controller
{
    /**
     * Shows the authenticated admin dashboard
     *
     * @return Factory|View
     */
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();

        $orders = Order::withTrashed()->get()->count();

        $comments = Comment::all()->count();

        $users = User::withTrashed()->get()->count();

        $admins = Admin::withTrashed()->get()->count();

        return view('admin.dashboard.index', compact('admin', 'orders', 'comments', 'users', 'admins'));
    }

    /**
     * Retrieves 20 latest orders
     *
     * @return View
     */
    public function latestOrders()
    {
        $orders = Order::withTrashed()->with([
            'products', 'payment', 'coupon', 'address.province', 'address.city',
            'user' => function ($query) {
                $query->withTrashed();
            }
        ])->orderByDesc('created_at')->limit(20)->get();

        return view('admin.orders.latest-orders', compact('orders'));
    }

    /**
     * Retrieves 20 latest orders
     *
     * @return View
     */
    public function latestComments()
    {
        $comments = Comment::with([
            'user', 'product' => function ($query) {
                $query->withTrashed();
            }
        ])->orderByDesc('created_at')->limit(20)->get();

        return view('admin.comments.latest-comments', compact('comments'));
    }

    /**
     * Retrieves all users
     *
     * @return View
     */
    public function registeredUsers()
    {
        $users = User::withTrashed()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Changes user status (Enable, Disable)
     *
     * @param  int  $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function changeUserStatus($id)
    {
        $user = User::withTrashed()->find($id);

        if (is_null($user->deleted_at)) {
            $user->delete();
            return back()->with(['ok' => 'وضعیت کاربر '."[$user->name".' '."$user->last_name]".' تغییر کرد!']);
        }

        $user->restore();
        return back()->with(['ok' => 'وضعیت کاربر '."[$user->name".' '."$user->last_name]".' تغییر کرد!']);
    }

    /**
     * Shows admin's managing view
     *
     * @param  Request  $request
     * @return View
     * @throws AuthorizationException
     */
    public function adminsIndex(Request $request)
    {
        $this->authorize('manipulate', $request->user('admin'));

        $admins = Admin::withTrashed()->where('super_admin', '!=', 1)->paginate(10);

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Changes admin status (Enable, Disable)
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function changeAdminStatus(Request $request, $id)
    {
        $demanderAdmin = $request->user('admin');

        $this->authorize('manipulate', $demanderAdmin);

        $admin = Admin::withTrashed()->find($id);

        if (is_null($admin->deleted_at)) {
            $admin->delete();
            return back()->with(['ok' => 'وضعیت ادمین '."[$admin->name".' '."$admin->last_name]".' تغییر کرد!']);
        }

        $admin->restore();
        return back()->with(['ok' => 'وضعیت ادمین '."[$admin->name".' '."$admin->last_name]".' تغییر کرد!']);
    }

    /**
     * Shows admin profile view
     *
     * @param  Request  $request
     * @return View|Factory
     */
    public function profileView(Request $request)
    {
        $admin = $request->user('admin');

        return view('admin.dashboard.profile-edit', compact('admin'));
    }

    /**
     * Updates admin's profile
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function profileUpdate(Request $request)
    {
        $this->profileValidator($request);

        $admin = $request->user('admin');
        $admin->fill($request->all());
        $admin->saveOrFail();

        return redirect()->route('admin.dashboard')->with(['ok' => 'پروفایل شما با موفقیت به روزرسانی شد!']);
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
            'phone_number' => ['bail', 'required', 'numeric', 'digits_between:11,11', 'regex:/09[0-9]{9}/u']
        ], [
            'name.required' => 'عبارت نام نمیتواند خالی باشد!',
            'last_name.required' => 'عبارت نام خانوادگی نمیتواند خالی باشد!',
            'phone_number.required' => 'عبارت شماره تلفن نمیتواند خالی باشد!',
            'phone_number.numeric' => 'شماره تلفن وارد شده معتبر نیست!',
            'phone_number.digits_between' => 'شماره تلفن وارد شده معتبر نیست!',
            'phone_number.regex' => 'شماره تلفن وارد شده معتبر نیست!'
        ]);
    }
}
