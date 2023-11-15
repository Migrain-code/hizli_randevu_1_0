<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SmsConfirmation;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{
    public function showForgotView()
    {
        return view('customer.auth.phone-verify');
    }

    public function forgotPasswordPhone(Request $request)
    {
        $customer = Customer::where('phone', clearPhone($request->input('phone')))->first();
        if ($customer){
            $this->createVerifyCode($customer->phone);
            Session::put('phone', $customer->phone);
            return to_route('customer.forgotPasswordVerifyShow');
        } else{
            return back()->with('response', [
               'status' => "error",
               'message' => "Bu telefon numarası ile kayıtlı kullanıcı bulunamadı"
            ]);
        }
    }
    public function forgotPasswordVerifyShow()
    {
        return view('customer.auth.passwords.verify');
    }
    public function forgotPasswordVerify(Request $request)
    {
        $phone = Session::get('phone');
        $smsConfirmation = SmsConfirmation::where('code', $request->input('code'))
            ->where('phone', clearPhone($phone))
            ->first();

        if ($smsConfirmation){
            if ($smsConfirmation->expire_at < now()){
                $this->createVerifyCode($smsConfirmation->phone);
                $smsConfirmation->delete();
                return back()->with('response', [
                    'status'=>"warning",
                    'message'=>"Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ]);
            }
            else{
                $generatePassword = rand(100000, 999999);
                $customer = Customer::where('phone', $smsConfirmation->phone)->first();
                $customer->password = Hash::make($generatePassword);
                if ($customer->save()){
                    Sms::send($customer->phone, setting('speed_site_title') . " Giriş Yapmak için yeni şifreniz:  " . $generatePassword);
                    return to_route('customer.login')->with('response', [
                        'status'=>"success",
                        'message'=>"Telefonunuz Doğrulandı. Yeni Şifreniz Numaranıza Sms Olarak Gönderildi"
                    ]);
                }
            }
        }
        else{
            return back()->with('response', [
                'status'=>"error",
                'message'=>"Doğrulama Kodu Hatalı"
            ]);
        }
    }



    public function createVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = clearPhone($phone);
        $smsConfirmation->action = "CUSTOMER-FORGOT-PASSWORD";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send($smsConfirmation->phone, setting('speed_site_title') . " Şifre sıfırlama için, telefon numarası doğrulama kodunuz:  " . $generateCode);

        return $generateCode;
    }
}
