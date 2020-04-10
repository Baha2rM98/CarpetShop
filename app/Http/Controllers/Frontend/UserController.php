<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        return view('frontend.dashboard.index', compact('user', 'menus'));
    }
}
