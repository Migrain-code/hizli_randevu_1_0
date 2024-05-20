<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Password\ForgotPasswordRequest;
use App\Http\Requests\Auth\Password\PasswordVerifyRequest;
use App\Models\BusinessOfficial;
use App\Models\Customer;
use App\Models\SmsConfirmation;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Sifremi Unuttum
 */
class ResetPasswordController extends Controller
{
    /**
     * Telefon Kontrolü
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = Customer::where('phone', clearPhone($request->input('phone')))->first();
        if ($user) {
            $this->resetVerifyCode($request->input('phone'));
            return response()->json([
                'status' => "success",
                'message' => "Telefon Numaranıza Gönderilen Doğrulama Kodunu Giriniz"
            ]);
        } else {
            return response()->json([
                'status' => "warning",
                'message' => "Bu telefon numarası ile kayıtlı kullanıcı bulunamadı"
            ]);
        }
    }

    /**
     * Doğrulama
     * @param PasswordVerifyRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function verifyResetPassword(PasswordVerifyRequest $request)
    {
        $code = SmsConfirmation::where("code", $request->code)->where('action', 'CUSTOMER-FORGOT-PASSWORD')->first();
        if ($code) {
            if ($code->expire_at < now()) {
                $this->resetVerifyCode($code->phone);
                $code->delete();
                return response()->json([
                    'status' => "warning",
                    'message' => "Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ], 422);

            } else {
                $generatePassword = rand(100000, 999999);
                $user = Customer::where('phone', $code->phone)->first();
                if (!$user){
                    return response()->json([
                        'status' => "warning",
                        'message' => "Sistemsel Bir Hata Oluştu. Lütfen Destek Ekibimiz ile iletişime geçiniz"
                    ], 422);
                }
                $user->password = Hash::make($generatePassword);
                if ($user->save()) {
                    Sms::send($code->phone, setting('speed_message_title') . " Sistemine giriş için yeni şifreniz " . $generatePassword);
                    return response()->json([
                        'status' => "success",
                        'message' => "Telefon Numaranız doğrulandı. Sisteme giriş için yeni şifreniz gönderildi."
                    ]);
                }
            }
        } else{
            return response()->json([
                'status' => "danger",
                'message' => "Doğrulama Kodu Hatalı veya Yanlış Tuşladınız"
            ], 422);
        }
    }

    function resetVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = clearPhone($phone);
        $smsConfirmation->action = "CUSTOMER-FORGOT-PASSWORD";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send($smsConfirmation->phone, setting('speed_message_title') . " Şifre yenileme için, telefon numarası doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }

}
