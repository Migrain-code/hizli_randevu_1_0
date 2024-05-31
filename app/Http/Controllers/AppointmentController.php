<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\Business;
use App\Models\BusinessService;
use App\Models\Customer;
use App\Models\Personel;
use App\Models\PersonelRoom;
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
        $rooms = $business->activeRooms;
        /*service modal queries */

        $womanServicesArray = $business->services()->where('type', 1)->with('categorys')->get();
        $womanServiceCategories = $womanServicesArray->groupBy('categorys.name');
        $womanServices = $this->transformServices($womanServiceCategories);

        $manServicesArray = $business->services()->where('type', 2)->with('categorys')->get();
        $manServiceCategories = $manServicesArray->groupBy('categorys.name');
        $manServices = $this->transformServices($manServiceCategories);

        $unisexServicesArray = $business->services()->where('type', 3)->with('categorys')->get();
        $unisexServiceCategories = $unisexServicesArray->groupBy('categorys.name');
        $unisexServices = $this->transformServices($unisexServiceCategories);
        $array = ['businessName' => $business->name, 'businessSlug' => $business->slug];
        session()->put('appointment', $array);
        $selectedServices = [];
        $serviceIds = [];
        $ap_services = [];
        $selectedPersonelIds = [];
        $personels = [];
        $selectedPersonels = [];
        $remainingDate = [];
        $offDay = [];
        $filledTime = [];
        $i = 0;
        $remainingDate = [];

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
                $selectedPersonels = Personel::whereIn('id', array_unique($selectedPersonelIds))->get();
                while ($i <= 30) {
                    $remainingDate[] = Carbon::now()->addDays($i);
                    $i++;
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
        return view('appointment.step1', compact('business', 'rooms','personels', 'remainingDate', 'disabledDays', 'selectedPersonelIds', 'selectedServices', 'serviceIds', 'ap_services', 'selectedPersonels', 'womanServices', 'manServices', 'unisexServices'));
    }
    function transformServices($womanServiceCategories)
    {
        $transformedDataWoman = [];
        foreach ($womanServiceCategories as $category => $services) {

            $transformedServices = [];
            foreach ($services as $service) {
                //if ($service->personels->count() > 0) { //hizmeti veren personel sayısı birden fazla ise listede göster
                $transformedServices[] = [
                    'id' => $service->id,
                    'name' => $service->subCategory->getName(),
                    'price' => $service->price_type_id == 0 ? $service->price : $service->price . " - " . $service->max_price,
                ];

            }
            $transformedDataWoman[] = [
                'id' => $services->first()->category,
                'name' => $category,
                'services' => $transformedServices,
            ];
        }
        return $transformedDataWoman;
    }
    public function step1Store(Request $request)
    {
        $selectedRoomId = null;
        $roomPersonelIds = [];
        $business = Business::whereSlug(session('appointment')["businessSlug"])->first();
        if ($request->has('selection_room_id')){
            $selectedRoomId = $request->input('selection_room_id');

            $roomPersonelIds = PersonelRoom::where('business_id', $business->id)
                ->where('room_id', $selectedRoomId)
                ->pluck('personel_id')
                ->toArray();
        }

        return to_route('step1.show', [
            'business' => session('appointment')['businessSlug'],
            'request' => $request->all(),
            'roomPersonelIds' => $roomPersonelIds
        ]);
    }

    public function checkClock($personelId, $startTime, $endTime, $appointmentId = null)
    {
        $findPersonel = Personel::find($personelId);
        $appointments =  $findPersonel->appointments()->whereNotIn('status', [3])->get();
        foreach ($findPersonel->appointments as $appointment) {
            if ($appointment->appointment_id != $appointmentId) {
                // Randevuların çakışma durumunu kontrol et
                if (($startTime->lt($appointment->end_time) && $endTime->gt($appointment->start_time)) ||
                    ($endTime->gt($appointment->start_time) && $startTime->lt($appointment->end_time))) {
                    return true;
                }
            }
        }
        return false;
    }
    public function appointmentCreate(Request $request)
    {
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
            $customer->password = Hash::make(rand(100000, 999999));
            $customer->save();
            $appointment->customer_id = $customer->id;
        }

        $appointment->room_id = $request->room_id == 0 ? null : $request->room_id;
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
            if ($this->checkClock($request->personels[$index], $appointmentService->start_time, $appointmentService->end_time, $appointment->id)) {
                $appointment->services()->delete();
                $appointment->delete();
                return back()->with('response', [
                    'status' => "error",
                    'message' => "Seçtiğiniz saate " . $findService->time . " dakikalık hizmet seçtiniz. Bu saate randevu alamazsınız. Başka bir saat seçmelisiniz."
                ]);
            }
        }

        $appointment->start_time = $appointment->services()->first()->start_time;
        $appointment->end_time = $appointment->services()->skip($appointment->services()->count() - 1)->first()->end_time;


        $calculateTotal = $appointment->calculateTotal();
        $appointment->total = $calculateTotal;
        if ($business->approve_type == 0) {
            $appointment->status = 1; // Otomatik onay
            foreach ($appointment->services as $service){
                $service->status = 1;
                $service->save();
            }
        } else {
            $appointment->status = 0; // Onay bekliyor
        }


        if ($appointment->save()) {
            $message = $business->name. " İşletmesine ". $appointment->start_time->format('d.m.Y H:i'). " tarihine randevunuz oluşturuldu.";
            $appointment->customer->sendSms($message);
            $appointment->sendPersonelNotification();
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
        foreach ($business->appointments()->whereNotIn('status', [3])->get() as $appointment) {
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
        $filledTime = $this->findTimes($business, $request->room_id);

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
        $getDate = Carbon::parse($request->input('date'), 'UTC');
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

                $disabledDays[] = $this->findTimes($personel, $request->room_id);

                if ($getDate->dayOfWeek == $business->off_day) {
                    return response()->json([
                        "status" => "error",
                        "message" => "İşletme bu tarihte hizmet vermemektedir"
                    ]);
                } else {
                    if (in_array($getDate->dayOfWeek, $personel->restDays()->pluck('day_id')->toArray())) {
                        return response()->json([
                            "status" => "error",
                            "message" => "Personel bu tarihte hizmet vermemektedir"
                        ]);
                    } else {
                        if ($personel->checkDateIsOff($getDate)) {
                            return response()->json([
                                "status" => "error",
                                "message" => 'Personel bu tarihte hizmet vermemektedir',

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
                    $disabledClocks[] = $this->findTimes($personel, $request->room_id);
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

    public function findTimes($personel, $room_id)
    {
        $disableds = [];

        // personelin dolu randevu saatlerini al iptal edilmişleri de dahil et
        $appointments = $personel->appointments()->whereNotIn('status', [3])->get();

        foreach ($appointments as $appointment) {
            $startDateTime = Carbon::parse($appointment->start_time);
            $endDateTime = Carbon::parse($appointment->end_time);

            $currentDateTime = $startDateTime->copy();
            while ($currentDateTime < $endDateTime) {

                $disableds[] = $currentDateTime->format('d.m.Y H:i');

                $currentDateTime->addMinutes(intval($personel->appointmentRange->time));
            }
        }

        // randevu almaya 30 dk öncesine kadar izin ver
        $startTime = Carbon::parse($personel->start_time);
        $endTime = Carbon::parse($personel->end_time);
        for ($i=$startTime;  $i < $endTime; $i->addMinutes(intval($personel->appointmentRange->time))){
            if ($i < now()->addMinutes(5)){
                $disableds[] = $i->format('d.m.Y H:i');
            }
        }
        $business = $personel->business;
        if (isset($room_id)){
            // oda tipi seçilmşse o odadaki randevuları al ve disabled dizisine ata
            $appointmentsBusiness = $business->appointments()->where('room_id', $room_id)->whereNotIn('status', [3])->get();
            foreach ($appointmentsBusiness as $appointment) {
                $businessStartDateTime = Carbon::parse($appointment->start_time);
                $businessEndDateTime = Carbon::parse($appointment->end_time);

                $businessCurrenDateTime = $businessStartDateTime->copy();
                while ($businessCurrenDateTime <= $businessEndDateTime) {

                    $disableds[] = $businessCurrenDateTime->format('d.m.Y H:i');

                    $businessCurrenDateTime->addMinutes(intval($business->range->time));
                }
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
