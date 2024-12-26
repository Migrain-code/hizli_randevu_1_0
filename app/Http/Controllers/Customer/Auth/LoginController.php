<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $loginImages = Ads::whereStatus(1)->where('type', 7)->get();
        return view('customer.auth.login', compact('loginImages'));
    }

    public function guard()
    {
        return Auth::guard('customer');
    }
    public function username()
    {
        return 'phone';
    }

    public function login(Request $request)
    {
        $phone = clearPhone($request->input('phone'));
        $user = null;

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

        if ($user && Hash::check($request->input('password'), $user->password)) {
            $user->checkPermissions();
            Auth::loginUsingId($user->id);
            return to_route('customer.home');
        } else {
            return to_route('customer.login')->with('response', [
                'status' => "danger",
                'message' => "Telefon Numarası veya Şifre Hatalı"
            ]);
        }
    }
}
