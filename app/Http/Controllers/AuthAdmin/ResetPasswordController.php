<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Admin;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\PasswordReset;
use App\SMSPanel\SMS;
use App\Token;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class ResetPasswordController extends Controller
{
    use Helper;

    /**
     * Shows recovery password view
     *
     * @return View
     */
    public function recoverPasswordView()
    {
        return view('admin.auth.recover-password');
    }

    /**
     * Sends verification code to admin
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function sendVerificationCode(Request $request)
    {
        $this->validate($request, ['phone_number' => 'required'],
            ['phone_number.required' => 'ابتدا شماره موبایل را وارد کنید!']);

        $phone = $request->input('phone_number');

        if (Admin::where('phone_number', $phone)->doesntExist()) {
            return back()->with(['error' => 'شماره وارد شده معتبر نیست!']);
        }

        mt_srand(intval($this->timestamp()));
        $code = str_shuffle(substr(strval(mt_rand(1, mt_getrandmax())), 0, 6));

        $result = SMS::forceSend('verify', $phone, $code);
        if (!$result) {
            return back()->with(['error' => 'خطایی در سیستم رخ داده است، مجددا تلاش کنید.']);
        }

        $resetPassword = new PasswordReset();
        $resetPassword->phone = $phone;
        $resetPassword->token = encrypt($code);
        $resetPassword->saveOrFail();

        return redirect()->route('admin.verify.code', ['id' => $resetPassword->id])
            ->with(['ok' => "کد بازیابی برای شماره {$phone} ارسال شد."]);
    }

    /**
     * Shows code verification view
     *
     * @return View
     */
    public function codeVerificationView()
    {
        return view('admin.auth.code-verification');
    }

    /**
     * Verifies recovery code
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function codeVerification(Request $request, $id)
    {
        $this->validate($request, ['vCode' => 'required'],
            ['vCode.required' => 'ابتدا کد بازیابی را وارد کنید!']);

        $code = $request->input('vCode');

        $items = PasswordReset::where('expired', 0)->get();

        $phone = null;

        foreach ($items as $record) {
            if (decrypt($record->token) === $code) {
                $phone = $record->phone;
                $record->update(['expired' => 1]);
                $token = encrypt($phone);
                (new Token(['token' => $token]))->saveOrFail();
                return redirect()->route('admin.reset.pass', ['token' => $token]);
            }
        }

        PasswordReset::whereId($id)->update(['expired' => 1]);
        return redirect()->route('admin.recover.pass')->with(['error' => 'کد وارد شده معتبر نیست، مجددا تلاش کنید.']);
    }

    /**
     * Returns reset password view
     *
     * @param  string  $token
     * @return View|RedirectResponse
     */
    public function resetPasswordView($token)
    {
        try {
            decrypt($token);
        } catch (\RuntimeException $exception) {
            abort(404);
        }

        if (Token::where('token', $token)->first()->expired === 1) {
            abort(404);
        }
        Token::where('token', $token)->first()->update(['expired' => 1]);

        return view('admin.auth.reset-password');
    }

    /**
     * Reset the admin's password
     *
     * @param  Request  $request
     * @param  string  $token
     * @return RedirectResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function resetPassword(Request $request, $token)
    {
        $this->passwordValidator($request);

        $phone = decrypt($token);

        $newPass = $request->input('new_password');

        $admin = Admin::where('phone_number', $phone)->first();
        $admin->password = Hash::make($newPass);
        $admin->saveOrFail();

        return redirect()->route('admin.login.form')->with(['ok' => 'رمزعبور شما با موفقیت بازیابی شد!']);
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
