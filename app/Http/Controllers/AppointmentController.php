<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\Business;
use App\Models\BusinessService;
use App\Models\Customer;
use App\Models\Personel;
use App\Models\ServiceCategory;
use App\Models\SmsConfirmation;
use App\Services\Sms;
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
                $filledTime = $this->findTimesBusiness($business);

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
        //$request->dd();
        $request->validate([
            'services' => "required",
            'personels' => "required",
            'business_id' => "required",
            'appointment_time' => "required",
            'appointment_date' => "required",
        ]);
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
            $customer->phone = clearPhone($request->input('phone'));
            $customer->email = null;
            $customer->image = "admin/users.svg";
            $customer->password = Hash::make(rand(100000, 999999));
            $customer->save();
            $appointment->customer_id = $customer->id;
        }

        if ($business->approve_type == 0) { //otomatik onay
            $appointment->status = 1;
        } else {
            $appointment->status = 0;
        }
        $appointment->save();
        $appointmentStartTime = Carbon::parse($request->appointment_time);
        foreach ($request->services as $index => $serviceId) {
            $findService = BusinessService::find($serviceId);
            $appointmentService = new AppointmentServices();
            $appointmentService->personel_id = $request->personels[$index];
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $appointmentStartTime;
            $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time);
            $appointmentService->appointment_id = $appointment->id;
            $appointmentService->save();
        }

        $appointment->start_time = $appointment->services()->first()->start_time;
        $appointment->end_time = $appointment->services()->skip($appointment->services()->count() - 1)->first()->end_time;
        if ($appointment->save()) {
            return to_route('appointment.success', $appointment->id)->with('response', [
                'status' => "success",
                'message' => "Randevunuz " . $appointment->start_time . " - " . $appointment->end_time . " arasına randevunuz oluşturuldu",
            ]);
        }

        return back()->with('response', [
           'status' => "error",
           'message' => "Bir hata sebebiyle randevunuz oluşturulamadı lütfen tekrar deneyiniz"
        ]);

    }

    public function step5Show($appointment)
    {
        $appointment = Appointment::find($appointment);
        $business = $appointment->business;
        $customer = $appointment->customer;
        $customer->sendSms($business->name . ' İşletmesine ' . $appointment->start_time . ' - ' . $appointment->end_time . ' arasında randevunuz alındı.');
        return view('appointment.step5', compact('appointment', 'business'));
    }

    public function findTimesBusiness($business)
    {
        $disableds = [];
        foreach ($business->appointments()->whereNotIn('status', [8])->get() as $appointment) {
            $startDateTime = Carbon::parse($appointment->start_time);
            $endDateTime = Carbon::parse($appointment->end_time);

            $currentDateTime = $startDateTime->copy();
            while ($currentDateTime <= $endDateTime) {
                $disableds[] = $currentDateTime->format('d.m.Y H:i');
                $currentDateTime->addMinutes($business->range->time);
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

    public function getClock(Request $request)
    {
        $getDate = Carbon::parse($request->date);
        $business = Business::find($request->business_id);
        $uniquePersonals = array_unique($request->personals);

        // personelleri gelen id lere göre db den collection olarak al
        $personels = [];
        foreach ($uniquePersonals as $id) {
            $personels[] = Personel::find($id);
        }
        $clocks = [];
        if (count($uniquePersonals) == 1) {
            foreach ($personels as $personel) {

                $disabledDays[] = $this->findTimes($personel);

                if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                    $clocks[] = [
                        'id' => $getDate->format('d_m_Y_'),
                        'saat' => 'İşletme bu tarihte hizmet vermemektedir',
                        'date' => $getDate->format('d.m.Y'),
                        'value' => $getDate->format('d.m.Y '),
                        'durum' => false,
                    ];
                    return response()->json([
                        "status" => "error",
                        "message" => "İşletme bu tarihte hizmet vermemektedir"
                    ]);
                } else {
                    if (in_array(Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek, $personel->restDays()->pluck('day_id')->toArray())) {
                        $clocks[] = [
                            'id' => $getDate->format('d_m_Y_'),
                            'saat' => 'Personel bu tarihte hizmet vermemektedir',
                            'date' => $getDate->format('d.m.Y'),
                            'value' => $getDate->format('d.m.Y '),
                            'durum' => false,
                        ];
                        return response()->json([
                            "status" => "error",
                            "message" => "Personel bu tarihte hizmet vermemektedir"
                        ]);
                    } else {
                        if ($personel->checkDateIsOff($getDate)) {
                            $clocks[] = [
                                'id' => $getDate->format('d_m_Y_'),
                                'saat' => 'Personel ' . Carbon::parse($personel->stayOffDays->start_time)->format('d.m.Y H:i') . " tarihinden " . Carbon::parse($personel->stayOffDays->end_time)->format('d.m.Y H:i') . " Tarihine Kadar İzinlidir",
                                'date' => $getDate->format('d.m.Y'),
                                'value' => $getDate->format('d.m.Y '),
                                'durum' => false,
                            ];
                            return response()->json([
                                "status" => "error",
                                "message" => 'Personel ' . Carbon::parse($personel->stayOffDays->start_time)->format('d.m.Y H:i') . " tarihinden " . Carbon::parse($personel->stayOffDays->end_time)->format('d.m.Y H:i') . " Tarihine Kadar İzinlidir",

                            ]);
                        } else {
                            for ($i = \Illuminate\Support\Carbon::parse($personel->start_time); $i < \Illuminate\Support\Carbon::parse($personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                $clocks[] = [
                                    'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                    'saat' => $i->format('H:i'),
                                    'date' => $getDate->format('d.m.Y'),
                                    'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                    'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                ];
                            }


                        }

                    }
                }


            }

        } else { // birden fazla ve farklı personel seçilmişse

            if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                $clocks[] = [
                    'id' => $getDate->format('d_m_Y_'),
                    'saat' => 'İşletme bu tarihte hizmet vermemektedir',
                    'date' => $getDate->format('d.m.Y'),
                    'value' => $getDate->format('d.m.Y '),
                    'durum' => false,
                ];
                return response()->json([
                    "status" => "error",
                    "message" => "İşletme bu tarihte hizmet vermemektedir"
                ]);
            } else {
                // işletme çalışma saatlerine randevu aralığına göre diziye ekle
                $businessClocks = [];
                for ($i = \Illuminate\Support\Carbon::parse($business->start_time); $i < \Illuminate\Support\Carbon::parse($business->end_time); $i->addMinute($business->range->time)) {
                    $businessClocks[] = $getDate->format('d.m.Y ' . $i->format('H:i'));
                }
                // personellerin dolu saatlerini bul
                $disabledClocks = [];
                foreach ($personels as $personel) {
                    $disabledClocks[] = $this->findTimes($personel);
                }
                // diziyi tek boyuta düşür
                $flattenedArray = [];
                foreach ($disabledClocks as $subArray) {
                    $flattenedArray = array_merge($flattenedArray, $subArray);
                }
                // dizi deki aynı olan verileri kaldır
                $disabledTimes = array_unique($flattenedArray);

                // hizmetlerin sürelerini al ve toplam süreye ekle
                $totalMinute = 0;
                foreach ($request->services as $serviceId) {
                    $service = BusinessService::find($serviceId);
                    $totalMinute += $service->time;
                }
                $totalMinutes = $totalMinute;

                foreach ($businessClocks as $index => $clock) {

                    $i = Carbon::parse($clock);
                    $clocks[] = array(
                        'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                        'saat' => $i->format('H:i'),
                        'date' => $getDate->format('d.m.Y'),
                        'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                        // işletmenin çalışma saatleri ile personelin çalışma saatlerini karşılaştır aynı olanları false yap
                        'durum' => !in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledTimes),
                    );
                }
                $found = false;
                $startTime = null;
                $currentTime = null;
                $totalTime = 0;
                foreach ($clocks as $clock) {
                    if ($clock['durum']) {
                        if ($currentTime === null) {
                            $currentTime = Carbon::parse($clock['value']);
                            $startTime = $currentTime;
                        } else {
                            $nextTime = Carbon::parse($clock['value']);
                            $timeDifference = $nextTime->diffInMinutes($currentTime);
                            $totalTime += $timeDifference;

                            // Eğer toplam süre  60 dakika veya daha fazla ise, durumu false olarak ayarla
                            if ($totalTime >= $totalMinutes) {
                                $found = true;
                                break;
                            }

                            $currentTime = $nextTime;
                        }
                    } else {
                        $currentTime = null;
                        $totalTime = 0; // Boş alan başladığında toplam süreyi sıfırlayın
                    }
                }

                if (!$found) {
                    return response()->json([
                        "status" => "error",
                        "message" => "Seçtiğiniz Hizmetler için uygun randevu aralığı bulunmamaktadır. Personeli veya Hizmeti Değiştirerek Yeniden Saat Arayabilirsiniz."
                    ]);
                }
            }
        }
        return response()->json($clocks);


    }

    public function findTimes($personel)
    {
        $disableds = [];
        $now = Carbon::now(); // Şu anki tarih ve saat
        $appointments = $personel->appointments()->whereNotIn('status', [8])->get();

        foreach ($appointments as $appointment) {
            $startDateTime = Carbon::parse($appointment->start_time);
            $endDateTime = Carbon::parse($appointment->end_time);

            $currentDateTime = $startDateTime->copy();
            while ($currentDateTime <= $endDateTime) {

                $disableds[] = $currentDateTime->format('d.m.Y H:i');

                $currentDateTime->addMinutes(intval($personel->appointmentRange->time));
            }
        }

        return $disableds;
    }

    public function phoneControl(Request $request)
    {

        $phone = clearPhone($request->phone);
        SmsConfirmation::where('phone', $phone)->delete();
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->action = "APPOINTMENT-CONTROL";
        $smsConfirmation->phone = $phone;
        $smsConfirmation->code = rand(100000, 999999);
        $smsConfirmation->expire_at = now()->addMinute(3);

        $smsConfirmation->save();
        Sms::send($phone, setting('speed_message_title').' Sistemi randevunuz için doğrulama kodunuz: ' . $smsConfirmation->code);

        return response()->json([
            'status' => "success",
            'message' => "Doğrulama Kodu Telefon Numaranıza Gönderildi.",
        ]);
    }

    public function phoneVerify(Request $request)
    {
        $phone = clearPhone($request->phone);
        $smsConfirmation = SmsConfirmation::where('phone', $phone)->where('code', $request->verify_code)->first();
        if ($smsConfirmation) {
            return response()->json([
                'status' => "success",
                'message' => "Telefon Numaranız Doğrulandı. Randevunuz Oluşturuluyor"
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Doğrulama Kodunu Hatalı veya Yanlış Tuşladınız Lütfen Tekrar Deneyin"
            ]);
        }
    }
}
