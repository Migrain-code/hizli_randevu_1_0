<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\Business;
use App\Models\Customer;
use App\Models\SmsConfirmation;
use App\Providers\RouteServiceProvider;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class VerifyController extends Controller
{
    public function index()
    {
        return view('customer.auth.verify');
    }

    public function phoneVerify()
    {
        $phone = Session::get('phone');
        return view('customer.auth.phone-verify', compact('phone'));
    }

    public function phoneVerifyAction(Request $request)
    {
        $verifierCustomer = Session::get('customer');

        $smsConfirmation = SmsConfirmation::where('code', $request->input('code'))
            ->where('phone', clearPhone($verifierCustomer->phone))
            ->first();

        if ($smsConfirmation){
            if ($smsConfirmation->expire_at < now()){
                $this->createVerifyCode($smsConfirmation->phone);
                $smsConfirmation->delete();
                return back()->with('response', [
                    'status'=>"warning",
                    'message'=>"Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ]);
            } else{

                $generatePassword = rand(100000, 999999);
                $verifierCustomer->password = Hash::make($generatePassword);
                $verifierCustomer->verify_phone = 1;
                $verifierCustomer->status = 1;
                if ($verifierCustomer->save()){
                    Sms::send($verifierCustomer->phone, setting('speed_site_title') . " Sistemine Giriş İçin Yeni Şifreniz:  " . $generatePassword);

                    return to_route('customer.login')->with('response', [
                        'status'=>"success",
                        'message'=>"Numaranız Doğrulandı Yeni Şifreniz Sms Olarak Gönderildi"
                    ]);
                }
                //Sms::send('');
            }
        }
        else{
            return back()->with('response', [
                'status'=>"error",
                'message'=>"Doğrulama Kodunu Hatalı veya Eksik Giriş Yaptınız"
            ]);
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

        Sms::send(clearPhone($phone), setting('speed_site_title') . " Sistemine Kayıt İçin Doğrulama Kodunuz:  " . $generateCode);

        return $generateCode;
    }


    public function accountVerify()
    {
        return view('customer.auth.account.verify');
    }

    public function accountVerifyAction(Request $request)
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
            } else{
                $verifierCustomer = Customer::where('phone', $phone)->first();
                $verifierCustomer->verify_phone = 1;
                if ($verifierCustomer->save()){
                    return to_route('customer.login')->with('response', [
                        'status'=>"success",
                        'message'=>"Numaranız Doğrulandı Sisteme Giriş Yapabilirsiniz"
                    ]);
                }
            }
        }
        else{
            return back()->with('response', [
                'status'=>"error",
                'message'=>"Doğrulama Kodunu Hatalı veya Eksik Giriş Yaptınız"
            ]);
        }
    }

}
