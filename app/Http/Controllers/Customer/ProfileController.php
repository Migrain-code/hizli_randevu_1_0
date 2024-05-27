<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Customer;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->dd();
        $request->validate([
            'phone' => "required",
            'name' => "required",
        ], [], [
            'phone' => "Telefon Numarası",
            'name' => "Ad Soyad",
        ]);
        $phone = clearPhone($request->input('phone'));
        $customer = auth('customer')->user();
        if ($customer->phone != $phone){
            if ($this->existPhone($phone)) {
                return back()->with('response',[
                    'status' => "error",
                    'message' => "Değiştirmek istediğiniz numara ile başka kayıtlı kullanıcı bulunuyor. Lütfen Başka bir numara giriniz."
                ]);
            }
        }

        $customer->name = $request->input('name');
        $customer->phone = $phone;
        if ($request->filled('year') && $request->filled('month') && $request->filled('day')) {
            $customer->birthday = $request->input('year') . "-" . $request->input('month') . "-" . $request->input('day');
        }
        $customer->email = $request->input('email');
        if ($request->filled('city_id')){
            $customer->city_id = $request->input('city_id');

        }if ($request->filled('district_id')){
            $customer->district_id = $request->input('district_id');
        }
        if ($request->hasFile('image')) {
            $response = UploadFile::uploadFile($request->file('image'), 'customer_profiles');
            $customer->image = $response["image"]["way"];
        }
        if ($customer->save()) {
            return back()->with('response', [
                'status' => "success",
                'message' => "Bilgileriniz Güncellendi"
            ]);
        }
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

    public function editPassword()
    {
        return view('customer.profile.change-password');
    }

    public function edit()
    {
        $allCities = City::orderBy('name')->get();

        $customer = auth('customer')->user();
        return view('customer.profile.setting', compact('customer', 'allCities'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => "required|confirmed",
        ], [], [
            'password' => "Şifre"
        ]);
        $customer = auth('customer')->user();
        $customer->password = Hash::make($request->input('password'));
        if ($customer->save()) {
            return back()->with('response', [
                'status' => "success",
                'message' => "Şifreniz Güncellendi"
            ]);
        }
    }
}
