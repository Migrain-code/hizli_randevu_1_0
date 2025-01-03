<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\Register\RegisterRequest;
use App\Http\Resources\Advert\AdvertListResource;
use App\Http\Resources\Customer\CustomerInfoResource;
use App\Models\Ads;
use App\Models\Customer;
use App\Models\Device;
use App\Models\SmsConfirmation;
use App\Services\NotificationService;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @group Customer Authentication
 *
 */
class AuthController extends Controller
{
    /**
     * Login Slider
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function loginSlider()
    {
        $loginSlider = Ads::where('type', 11)->whereStatus(1)->get();
        return response()->json(AdvertListResource::collection($loginSlider));
    }
    /**
     * Giriş Yap
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $phone = clearPhone($request->phone);
        if (Str::startsWith($phone, '0')) {
            $user = Customer::where('phone', 'like', '%' . $phone . '%')
                ->where('status', 1)
                ->first();

            // Eğer sonuç bulunamazsa başındaki "0"ı kaldırıp tekrar dene
            if (!$user) {
                $phoneWithoutZero = ltrim($phone, '0');
                $user = Customer::where('phone', 'like', '%' . $phoneWithoutZero . '%')
                    ->where('status', 1)
                    ->first();
            }
        } else {
            // Başında "0" yoksa önce olduğu gibi sorgula
            $user = Customer::where('phone', 'like', '%' . $phone . '%')
                ->where('status', 1)
                ->first();

            // Eğer sonuç bulunamazsa başına "0" ekleyip tekrar dene
            if (!$user) {
                $phoneWithZero = '0' . $phone;
                $user = Customer::where('phone', 'like', '%' . $phoneWithZero . '%')
                    ->where('status', 1)
                    ->first();
            }
        }
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'=> "error",
                'message' => 'Telefon Numarası veya şifre yanlış'
            ], 401);
        }
        if ($user->status == 0){
            return response()->json([
                'message' => 'Telefon Numarası veya şifre yanlış'
            ], 401);
        }
        if ($user->status == 2){
            return response()->json([
                'message' => 'Telefon Numarası veya şifre yanlış'
            ], 401);
        }
        $token = $user->createToken('Access Token')->accessToken;
        $title = "Merhaba ". $user->name;
        $message = "Hızlı Randevu Sistemine Hoşgeldiniz";
        if (isset($user->device)){
            $deviceToken = $request->input('device_token');
            if (isset($deviceToken) && $user->device->token != $deviceToken) { // İŞTE BU SATIR
                $device = $user->device;
                $device->token = $deviceToken;
                $device->save();
            }
            NotificationService::sendPushNotification($user->device->token, $title, $message);
        } else{

            if ($request->filled('device_token')){
                $device = new Device();
                $device->customer_id = $user->id;
                $device->token = $request->input('device_token');
                $device->type = 1;
                $device->save();
                NotificationService::sendPushNotification($device->token, $title, $message);

            }
        }
        return response()->json([
            'token' => $token,
            'user' => CustomerInfoResource::make($user),
        ]);
    }

    /**
     * Çıkış Yap
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Sistemden Çıkış Yapıldı']);
    }

    /**
     * Kayıt ol
     * @param \App\Http\Requests\Auth\Register\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        if ($this->existPhone(clearPhone($request->phone))) {
            return response()->json([
                'status' => "warning",
                'message' => "Bu telefon numarası ile kayıtlı kullanıcı bulunmakta."
            ], 422);
        } else {
            $this->createVerifyCode(clearPhone($request->phone));
            return response()->json([
                'status' => "success",
                'message' => "Telefon numaranıza bir doğrulama kodu gönderdik. Numaranızı doğruladıktan sonra kaydınız tamamlanacak"
            ]);
        }
    }

    public function existPhone($phone)
    {
        $existPhone = Customer::where('phone', $phone)->where('status', 1)->first();
        if ($existPhone != null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
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
