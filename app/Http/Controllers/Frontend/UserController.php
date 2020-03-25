<?php

namespace App\Http\Controllers\Frontend;

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
    public function dashboard()
    {
        $user = Auth::user();

        return view('frontend.dashboard.index', compact('user'));
    }
}
