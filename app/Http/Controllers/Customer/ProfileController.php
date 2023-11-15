<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'phone' => "required",
            'name' => "required",
            'email' => "required",
        ], [], [
            'phone' => "Telefon Numarası",
            'name' => "Ad Soyad",
            'email' => "E-posta",
        ]);

        $customer=auth('customer')->user();
        $customer->name=$request->input('name');
        $customer->phone=clearPhone($request->input('phone'));
        $customer->birthday=$request->input('year')."-".$request->input('month')."-". $request->input('day');
        $customer->email=$request->input('email');
        $customer->city_id=$request->input('city_id');
        $customer->district_id=$request->input('district_id');
        if ($request->hasFile('image')) {
            $response = UploadFile::uploadFile($request->file('image'), 'customer_profiles');
            $customer->image = $response["image"]["way"];
        }
        if ($customer->save()){
            return back()->with('response', [
                'status'=>"success",
                'message'=>"Bilgileriniz Güncellendi"
            ]);
        }
    }

    public function editPassword()
    {
        return view('customer.profile.change-password');
    }
    public function edit()
    {
        $customer=auth('customer')->user();
        return view('customer.profile.setting', compact('customer'));
    }
    public function changePassword(Request $request)
    {
        $request->validate([
           'password'=>"required|confirmed",
        ],[],[
            'password'=>"Şifre"
        ]);
        $customer=auth('customer')->user();
        $customer->password=Hash::make($request->input('password'));
        if ($customer->save()){
            return back()->with('response', [
                'status'=>"success",
                'message'=>"Şifreniz Güncellendi"
            ]);
        }
    }
}
