<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\Password\ChangePasswordRequest;
use App\Http\Requests\Auth\Register\RegisterRequest;
use App\Http\Requests\Customer\Setting\CustomerUpdateRequest;
use App\Http\Resources\Customer\CustomerInfoResource;
use App\Models\Customer;
use App\Models\SmsConfirmation;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Kullanıcı Bilgileri
 *
 */
class UserController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->customer = auth('api')->user();
            return $next($request);
        });
    }
    /**
     * Tüm Bilgileri
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(CustomerInfoResource::make($this->customer));
    }

    /**
     * Şifre Değiştir
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $customer = $this->customer;
        $customer->password = Hash::make($request->password);
        if ($customer->save()){
            return response()->json([
               'status' => "success",
               'message' => "Şifreniz Güncellendi"
            ]);
        }
        return response()->json([
            'status' => "warning",
            'message' => "Sistemsel Bir Hata Oluştu. Lütfen Çıkış Yapıp Tekrar Deneyiniz"
        ], 422);
    }

    /**
     * Kullanıcı Bilgileri Güncelleme
     * @param CustomerUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInfo(CustomerUpdateRequest $request)
    {
        $phone = $request->input('phone');
        $customer = $this->customer;
        if ($customer->phone != $phone){
            if ($this->existPhone($phone)){
                return response()->json([
                    'status' => "error",
                    'message' => "Yeni Girdiğiniz numara ile kayıtlı kullanıcı kaydı bulunuyor. Lütfen Başka bir numara deneyiniz"
                ], 422);
            }
        }
        $customer->phone = $phone;
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->gender = $request->input('gender');
        $customer->birthday = $request->input('year')."-".$request->input('month')."-". $request->input('day');
        $customer->city_id = $request->input('city_id');
        $customer->district_id = $request->input('district_id');
        if ($customer->save()){
            return response()->json([
                'status' => "success",
                'message' => "Bilgileriniz Başarılı Bir Şekilde Güncellendi"
            ]);
        }

        return response()->json([
            'status' => "warning",
            'message' => "Sistemsel Bir Hata Oluştu. Lütfen Çıkış Yapıp Tekrar Deneyiniz"
        ], 422);

    }

    public function existPhone($phone)
    {
        $existPhone = Customer::where('phone', $phone)->first();
        if ($existPhone != null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}