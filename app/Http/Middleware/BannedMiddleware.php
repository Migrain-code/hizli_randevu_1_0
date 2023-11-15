<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class BannedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('customer')->check() && auth('customer')->user()->status == 0) {
            Auth::guard('customer')->logout();
            return to_route('customer.login')->with('response', [
                'status'=>"danger",
                'message'=>"Hesabınızın erişimi sistem tarafından geçici olarak kısıtlandı, lütfen destek ekibimizle iletişime geçin",
            ]);
        }
        return $next($request);
    }
}
