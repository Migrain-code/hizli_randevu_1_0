<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\Business;
use App\Models\BusinessService;
use App\Models\Customer;
use App\Models\Personel;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AppointmentController extends Controller
{
    public function step1Show($business)
    {
        $business = Business::where('slug', $business)->firstOrFail();

        /*service modal queries */
        $womanServices = $business->services()->where('type', 1)->get();
        $manServices = $business->services()->where('type', 2)->get();
        $womanServiceCategories = $womanServices->groupBy('category');
        $manServiceCategories = $manServices->groupBy('category');
        $manCategories = [];
        $womanCategories = [];
        foreach ($manServiceCategories as $key => $value) {
            $manCategories[] = ServiceCategory::find($key);
        }
        foreach ($womanServiceCategories as $key => $value) {
            $womanCategories[] = ServiceCategory::find($key);
        }
        $array = ['businessName' => $business->name, 'businessSlug' => $business->slug];
        session()->put('appointment', $array);
        $selectedServices = [];
        $serviceIds = [];
        $ap_services = [];
        $selectedPersonelIds = [];
        $personels = [];
        $remainingDate = [];
        $offDay = [];
        $filledTime = [];
        $remainingDays = Carbon::now()->subDays(1)->diffInDays(Carbon::now()->copy()->endOfMonth());
        $disabledDays = [];

        if (isset(\request()["request"])) {
            if (isset(\request()["request"]["services"])) {
                foreach (\request()["request"]["services"] as $service_id) {
                    $selectedServices[] = BusinessService::find($service_id);
                    $serviceIds[] = $service_id;
                    $ap_services[] = BusinessService::find($service_id);
                }
            } else {
                return to_route('business.detail', $business->slug);
            }
            if (isset(\request()["request"]["personels"])) {
                foreach (\request()["request"]["personels"] as $personel_id) {
                    $selectedPersonelIds [] = $personel_id;
                }
            }
            if (isset(\request()["request"]["step"])) { /*personel seçilmiş ise*/

                foreach ($selectedPersonelIds as $personel_id) {
                    $personels[] = Personel::find($personel_id);
                }
                for ($i = 0; $i < $remainingDays; $i++) {
                    $days = Carbon::now()->addDays($i);
                    if ($days < Carbon::now()->endOfMonth()) {
                        $remainingDate[] = $days;
                    }
                }
                $filledTime = $this->findTimes($business);

                foreach ($filledTime as $time) {
                    $disabledDays[] = $time;
                }
            }
        } else {
            return to_route('business.detail', $business->slug);
        }

        /*end modal queries*/
        return view('appointment.step1', compact('business', 'personels', 'remainingDate', 'disabledDays', 'selectedPersonelIds', 'manServiceCategories', 'womanServiceCategories', 'womanCategories', 'manCategories', 'selectedServices', 'serviceIds', 'ap_services'));
    }

    public function step1Store(Request $request)
    {
        return to_route('step1.show', ['business' => session('appointment')["businessSlug"], 'request' => $request->all()]);
    }

    public function appointmentCreate(Request $request)
    {
        $request->dd();
        $business = Business::find($request->business_id);
        if (Auth::guard('customer')->check()) {
            $appointment = new Appointment();
            $appointment->business_id = $business->id;
            $appointment->customer_id = Auth::guard('customer')->id();
        } else {
            $request->validate([
                'name' => "required",
                'phone' => "required",
            ], [], [
                'name' => 'Ad',
                'phone' => 'Telefon',
            ]);
            $appointment = new Appointment();
            $appointment->business_id = $business->id;
            $customer = new Customer();
            $customer->name = $request->input('name');
            $customer->phone = $request->input('phone');
            $customer->email = null;
            $customer->image = "admin/users.svg";
            $customer->password = Hash::make(rand(100000, 999999));
            $customer->save();
            $appointment->customer_id = $customer->id;
        }

        if ($business->approve_type == 1) {
            $appointment->status = 1;
        } else {
            $appointment->status = 0;
        }
        $appointment->save();

        $loop = 0;
        $sumTime = 0;

        $start = 9999999999999;
        $end = 0;

        foreach ($request->services as $service) {
            $appointmentService = new AppointmentServices();
            $appointmentService->appointment_id = $appointment->id;
            $appointmentService->personel_id = $request->personels[$loop];
            $appointmentService->service_id = $service;

            $findService = BusinessService::find($service);
            $appointmentService->start_time = Carbon::parse($request->input('appointment_date') . ' ' . $request->input('appointment_time.' . $appointmentService->personel_id));
            $appointmentService->end_time = Carbon::parse($appointmentService->start_time)->addMinutes($findService->time);
            $sumTime += $findService->time;
            $appointmentService->save();
            $loop++;

            if (str_replace(':', '', $start) > str_replace(':', '', $request->input('appointment_time.' . $appointmentService->personel_id))) {
                $start = $request->input('appointment_time.' . $appointmentService->personel_id);
            }

            if (str_replace(':', '', $end) < str_replace(':', '', $request->input('appointment_time.' . $appointmentService->personel_id))) {
                $end = $request->input('appointment_time.' . $appointmentService->personel_id);
            }
        }

        $appointment->start_time = Carbon::parse($request->input('appointment_date') . ' ' . $start)->format('d.m.Y H:i');

        if ($loop > 1){
            $appointment->end_time = Carbon::parse($request->input('appointment_date') . ' ' . $end)->format('d.m.Y H:i');
        }else {
            $appointment->end_time = Carbon::parse($request->input('appointment_date') . ' ' . $start)->addMinutes($sumTime)->format('d.m.Y H:i');
        }

        $appointment->save();
        return to_route('appointment.success', $appointment->id);
    }

    public function step5Show($appointment)
    {
        $appointment = Appointment::find($appointment);
        $business = $appointment->business;
        $customer = $appointment->customer;
        $customer->sendSms($business->name . ' İşletmesine ' . $appointment->start_time . ' - ' . $appointment->end_time . ' arasında randevunuz alındı.');
        return view('appointment.step5', compact('appointment', 'business'));
    }

    public function findTimes($business)
    {
        $disableds = [];
        foreach ($business->appointments()->whereNotIn('status', [8])->get() as $appointment) {
            $startDateTime = Carbon::parse($appointment->start_time);
            $endDateTime = Carbon::parse($appointment->end_time);

            $currentDateTime = $startDateTime->copy();
            while ($currentDateTime <= $endDateTime) {
                $disableds[] = $currentDateTime->format('d.m.Y H:i');
                $currentDateTime->addMinutes($business->appoinment_range);
            }
        }

        return $disableds;
    }

    public function appointmentTimeControl(Request $request)
    {
        $business = Business::find($request->business_id);
        $filledTime = $this->findTimes($business);

        if (in_array($request->time, $filledTime)) {
            return response()->json([
                'title' => "Hata",
                'icon' => "error",
                'message' => "Seçtiğiniz Tarih ve saatte randevu kaydı yapıldı. Sistem üzerinde ayarlama yapmaya devam ederseniz kalıcı olarak engelleneceksiniz."
            ]);
        }

    }
}
