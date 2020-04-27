<?php

namespace App\Http\Controllers\Auth;

use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;

class ResetPasswordController extends Controller
{
    /**
     * Shows change password view of user's address
     *
     * @param  Request  $request
     * @return View|Factory
     */
    public function editPassword(Request $request)
    {
        $menus = Category::all();

        $user = $request->user();

        return view('auth.reset-password', compact('menus', 'user'));
    }

    /**
     * Registers a new password for user
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updatePassword(Request $request)
    {
        $this->passwordValidator($request);

        $user = $request->user();

        $oldPass = $request->input('old_password');
        $newPass = $request->input('new_password');

        if (!Hash::check($oldPass, $user->password)) {
            return back()->with(['error' => 'رمزعبور وارد شده صحیح نمی باشد!']);
        }

        $user->password = Hash::make($newPass);
        $user->saveOrFail();

        return redirect()->route('user.dashboard')->with(['success' => 'رمزعبور شما با موفقیت به روزرسانی شد!']);
    }

    /**
     * Returns verify email view
     *
     * @return View|Factory
     */
    public function recoveryView()
    {
        $menus = Category::all();

        return view('auth.verify-email', compact('menus'));
    }

    /**
     * Verifies user email
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function verifyEmail(Request $request)
    {
        $email = $request->input('email');

        if (!isset($email)) {
            return back()->with(['failure' => 'ابتدا ایمیل خود را وارد کنید!']);
        }

        if (User::where('email', $email)->doesntExist()) {
            return back()->with(['failure' => 'ایمیل وارد شده در پایگاه داده سیستم موجود نمی باشد!']);
        }

        return redirect()->route('recover.password.view', ['email' => encrypt($email)]);
    }

    /**
     * Returns recover password view
     *
     * @param  string  $email
     * @return View|RedirectResponse
     */
    public function recoverPasswordView($email)
    {
        try {
            decrypt($email);
        } catch (RuntimeException $exception) {
            abort(404);
        }

        $menus = Category::all();

        return view('auth.recover-password', compact('menus'));
    }

    /**
     * Recovers user's password
     *
     * @param  Request  $request
     * @param  string  $email
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function recoverPassword(Request $request, $email)
    {
        $this->passwordValidator($request);

        $email = decrypt($email);
        $newPass = $request->input('new_password');

        $user = User::where('email', $email)->first();
        $user->password = Hash::make($newPass);
        $user->saveOrFail();

        return redirect()->route('login')->with(['ok' => 'رمزعبور شما با موفقیت بازیابی شد!']);
    }

    /**
     * Validates user's password
     *
     * @param  Request  $request
     * @return array
     * @throws ValidationException
     */
    private function passwordValidator(Request $request)
    {
        return $this->validate($request, [
            'new_password' => 'min:8',
            'confirm_new_password' => ['bail', 'required', 'same:new_password']
        ], [
            'new_password.min' => 'رمز عبور وارد شده نمیتواند کمتر از 8 کاراکتر باشد!',
            'confirm_new_password.required' => 'تاییدیه رمز عبور نمیتواند خالی باشد!',
            'confirm_new_password.same' => 'رمز عبور جدید وارد شده با تاییدیه رمز عبور مطابقت ندارد!'
        ]);
    }
}
