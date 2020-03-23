<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Creates a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (!$this->isDatabaseConnected()) {
            abort(500, 'Database Connection Error');
        }
    }

    /**
     * Shows the application dashboard form
     *
     * @return Factory|View
     */
    public function dashboard()
    {
        $user = Auth::user();

        return view('frontend.dashboard.index', compact('user'));
    }
}
