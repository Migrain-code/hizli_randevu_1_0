<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register\RegisterVerifyRequest;
use App\Models\BusinessOfficial;
use App\Models\Customer;
use App\Models\SmsConfirmation;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Customer Authentication
 */
class VerifyController extends Controller
{
    /**
     * Telefon Doğrulama
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(RegisterVerifyRequest $request)
    {
        $code = SmsConfirmation::where("code", $request->code)->where('action', 'CUSTOMER-REGISTER')->first();
        if ($code) {
            if ($code->expire_at < now()) {

                $this->createVerifyCode($code->phone);
                $code->delete();
                return response()->json([
                    'status' => "warning",
                    'message' => "Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ], 422);

            } else {

                if ($code->phone == clearPhone($request->phone)) {
                    $generatePassword = rand(100000, 999999);

                    $user = new Customer();
                    $user->name = $request->name;
                    $user->phone = $code->phone;
                    $user->password = Hash::make($generatePassword);
                    $user->verify_phone = 1;
                    $user->save();

                    Sms::send($code->phone, config('speed_message_title') . " Sistemine giriş için şifreniz " . $generatePassword);
                    $code->delete();
                    return response()->json([
                        'status' => "success",
                        'message' => "Telefon Numaranız doğrulandı. Sisteme giriş için şifreniz gönderildi."
                    ]);
                } else {
                    return response()->json([
                        'status' => "success",
                        'message' => "Doğrulama Kodu Hatalı veya Yanlış Tuşladınız."
                    ], 422);
                }
            }

        } else {
            return response()->json([
                'status' => "danger",
                'message' => "Doğrulama Kodu Hatalı."
            ], 422);
        }

    }

    function createVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = clearPhone($phone);
        $smsConfirmation->action = "CUSTOMER-REGISTER";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send(clearPhone($phone), setting('speed_message_title') . " Sistemine kayıt için, telefon numarası doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }
}
