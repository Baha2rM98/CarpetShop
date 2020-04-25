<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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
     * @throws \Exception
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
}
