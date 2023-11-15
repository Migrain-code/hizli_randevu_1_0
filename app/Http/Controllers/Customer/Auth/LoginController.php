<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        return view('customer.auth.login');
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
        $user = Customer::where('phone', clearPhone($request->input('phone')))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
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
