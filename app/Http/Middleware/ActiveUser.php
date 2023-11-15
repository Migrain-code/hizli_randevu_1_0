<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('customer')->check() && auth('customer')->user()->verify_phone != 1) {
            Session::put('phone', auth('customer')->user()->phone);
            createVerifyCode(auth('customer')->user()->phone);
            Auth::guard('customer')->logout();
            return to_route('customer.login')->with('response', [
                'status'=>"danger",
                'message'=>"Telefon Numaranızı doğrulamadan sisteme giriş yapamazsınız doğrulamak için telefonunuza gönderilen doğrulama kodunu giriniz",
            ]);
        }
        return $next($request);
    }
}
