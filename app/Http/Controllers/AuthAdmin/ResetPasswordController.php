<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    /**
     * Shows recovery password view
     *
     * @return View
     */
    public function recoverPasswordView()
    {
        return view('admin.auth.recover-password');
    }
}
