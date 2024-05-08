<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\Ads;
use App\Models\Customer;
use App\Models\Email;
use App\Models\Image;
use App\Models\ProjectRequest;
use App\Models\Promoter;
use App\Models\SmsConfirmation;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\Sms;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    public function showRegistrationForm()
    {
        $loginImages = Ads::whereStatus(1)->where('type', 7)->get();
        return view('customer.auth.register', compact('loginImages'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        if (isset($data['phone'])) {
            $data['phone'] = clearPhone($data['phone']);
        }

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:customers'],
        ], [], [
            'name' => 'Ad Soyad',
            'phone' => 'Telefon',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|Customer
     */
    protected function create(array $data)
    {
        $generateCode=rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = clearPhone($data['phone']);
        $smsConfirmation->action = "CUSTOMER-REGISTER";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send($smsConfirmation->phone,setting('speed_message_title'). " Sistemine kayıt için, telefon numarası doğrulama kodunuz ". $generateCode);
        $customer = new Customer();
        $customer->phone = clearPhone($data['phone']);
        $customer->name = $data['name'];
        $customer->password = Hash::make(Str::random(8));
        Session::put('customer', $customer);
        return $customer;
    }

    public function registered()
    {
        return to_route('customer.phone.verify')->with('response', [
            'status' => "success",
            'message' => "Telefon Numaranıza Bir Doğrulama Kodu Gönderdik"
        ]);
    }

}
