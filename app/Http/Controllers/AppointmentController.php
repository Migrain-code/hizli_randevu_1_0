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

    public function checkPersonelClock($business,$personelId, $startTime, $endTime, $roomId)
    {

        $findPersonel = Personel::find($personelId);
        $disabledTimes = $this->findDisabledTimes($business,$findPersonel, $startTime, $roomId);

        $disableds = [];
        $currentDateTime = $startTime->copy();

        while ($currentDateTime < $endTime) {
            $disableds[] = $currentDateTime->format('d.m.Y H:i');
            $currentDateTime->addMinutes(intval($findPersonel->appointmentRange->time));
        }
        $disabledConfig = [];
        foreach ($disableds as $disabledTime) {
            if (in_array($disabledTime, $disabledTimes)) {
                $disabledConfig[] = 1;
            } else {
                $disabledConfig[] = 0;
            }
        }

        return in_array(1, $disabledConfig);
    }
    public function findDisabledTimes($business,$personel, $appointmentStartTime, $roomId)
    {
        $appointments = $personel->appointments()->whereDate('start_time', $appointmentStartTime->toDateString())->whereNotIn('status', [3])->get();
        $disabledTimes = [];
        foreach ($appointments as $appointment) {
            $startDateTime = $appointment->start_time;
            $endDateTime = $appointment->end_time;

            $currentDateTime = $startDateTime->copy();
            while ($currentDateTime < $endDateTime) {

                $disabledTimes[] = $currentDateTime->format('d.m.Y H:i');

                $currentDateTime->addMinutes(intval($personel->appointmentRange->time));
            }
        }

        if (isset($roomId) && $roomId > 0) {
            // oda tipi seçilmşse o odadaki randevuları al ve disabled dizisine ata
            $appointmentsBusiness = $business->appointments()->where('room_id', $roomId)
                ->whereDate('start_time', $appointmentStartTime->toDateString())
                ->whereNotIn('status', [3])->get();
            foreach ($appointmentsBusiness as $appointment) {
                $businessStartDateTime = Carbon::parse($appointment->start_time);
                $businessEndDateTime = Carbon::parse($appointment->end_time);

                $businessCurrenDateTime = $businessStartDateTime->copy();
                while ($businessCurrenDateTime < $businessEndDateTime) {

                    $disabledTimes[] = $businessCurrenDateTime->format('d.m.Y H:i');

                    $businessCurrenDateTime->addMinutes(intval($business->range->time));
                }
            }
        }
        return $disabledTimes;
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
        $approve_types = [];
        foreach ($request->services as $index => $serviceId) {
            $findService = BusinessService::find($serviceId);
            $appointmentService = new AppointmentServices();
            $appointmentService->personel_id = $request->personels[$index];
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $appointmentStartTime;
            $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time);


            $approve_types[] = $findService->approve_type;

            if ($this->checkPersonelClock($business,$request->personels[$index], $appointmentService->start_time, $appointmentService->end_time, $appointment->id)) {
                $appointment->services()->delete();
                $appointment->delete();
                return back()->with('response', [
                    'status' => "error",
                    'message' => "Seçtiğiniz saate " . $findService->time . " dakikalık hizmet seçtiniz. Bu saate randevu alamazsınız. Başka bir saat seçmelisiniz."
                ]);
            }
            $appointmentService->appointment_id = $appointment->id;
            $appointmentService->save();
        }

        $appointment->start_time = $appointment->services()->first()->start_time;
        $appointment->end_time = $appointment->services()->skip($appointment->services()->count() - 1)->first()->end_time;


        $calculateTotal = $appointment->calculateTotal();
        $appointment->total = $calculateTotal;
        if (in_array(1, $approve_types)) { // hizmet manuel onay ise
            $appointment->status = 0; // Otomatik onay
            foreach ($appointment->services as $service) {
                $service->status = 0;
                $service->save();
            }
            $message = $business->name. " İşletmesine Randevunuz talebiniz alınmıştır. İşletmemiz en kısa sürede sizi bilgilendirecektir.";

        } else {
            $appointment->status = 1; // Otomatik onay ise
            foreach ($appointment->services as $service) {
                $service->status = 1;
                $service->save();
            }
            $message = $business->name. " İşletmesine ". $appointment->start_time->format('d.m.Y H:i'). " tarihine randevunuz oluşturuldu.";
        }

        if ($appointment->save()) {
            $appointment->customer->sendSms($message);
            $appointment->sendPersonelNotification();
            return to_route('appointment.success', $appointment->id)->with('response', [
                'status' => "success",
                'message' => $message,
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
        $getDate = Carbon::parse($request->input('date'));
        $business = Business::find($request->business_id);
        $uniquePersonals = array_unique($request->personals);
        $serviceIds = [];
        // personelleri gelen id lere göre db den collection olarak al
        $personels = [];
        foreach ($uniquePersonals as $index => $id) {
            $personels[] = Personel::find($id);
            $serviceIds[] = $request->services[$index];
        }
        $clocks = [];
        if (count($uniquePersonals) == 1) {
            foreach ($personels as $personel) {

                $disabledDays[] = $this->findTimes($personel, $request->room_id);
                if ($business->isClosed($request->date)){
                    return response()->json([
                        'status' => "error",
                        'message' => "İşletme bu tarihte hizmet vermemektedir"
                    ]);
                }
                if (isset($business->off_day) && $getDate->dayOfWeek == $business->off_day) {
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

                            //tüm koşullar sağlanmış ise personel saat takvimi

                            $checkCustomWorkTime = $personel->isCustomWorkTime($request->date);

                            if (isset($checkCustomWorkTime)) {
                                if (Carbon::parse($checkCustomWorkTime->start_time) < Carbon::parse($checkCustomWorkTime->end_time)) {
                                    for ($i = Carbon::parse($checkCustomWorkTime->start_time); $i < Carbon::parse($checkCustomWorkTime->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }
                                } else {

                                    for ($i = Carbon::parse($checkCustomWorkTime->start_time); $i < Carbon::parse($checkCustomWorkTime->end_time)->endOfDay(); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];

                                    }

                                    $newStartTime = $getDate->addDays(1);
                                    for ($i = $newStartTime; $i < Carbon::parse($newStartTime->toDateString() . $checkCustomWorkTime->end_time); $i->addMinute($personel->appointmentRange->time)) {

                                        $clocks[] = [
                                            'id' => $i->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $i->format('d.m.Y'),
                                            'value' => $i->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($i->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }

                                }

                            } else {
                                if (Carbon::parse($personel->start_time) < Carbon::parse($personel->end_time)) {
                                    for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }
                                } else {
                                    $lastTime = "";
                                    for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time)->endOfDay(); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                        $lastTime = $i->format('H:i');
                                    }

                                    $newStartTime = $getDate->addDays(1);

                                    for ($i = $newStartTime; $i < Carbon::parse($newStartTime->toDateString() . $personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $i->format('d_m_Y_H_i'),
                                            'saat' => $i->format('H:i'),
                                            'date' => $i->format('d.m.Y'),
                                            'value' => $i->format('d.m.Y H:i'),
                                            'durum' => in_array($i->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }

                                }

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
                ], 200);
            } else {
                // işletme çalışma saatlerine randevu aralığına göre diziye ekle
                foreach ($personels as $personel) {

                    $disabledDays[] = $this->findTimes($personel, $request->room_id);
                    //işletme kapalı gün kontrolü
                    if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                        return response()->json([
                            "status" => "error",
                            "message" => "İşletme bu tarihte hizmet vermemektedir"
                        ], 200);
                    } else {
                        //işletme kapalı değilse personel izin kontrolü
                        if (in_array(Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek, $personel->restDays()->pluck('day_id')->toArray())) {
                            return response()->json([
                                "status" => "error",
                                "message" => "Personel ".$personel->name." bu tarihte hizmet vermemektedir"
                            ], 200);
                        } else {
                            //personel kapalı değilse personel izin gün kontrolü
                            if ($personel->checkDateIsOff($getDate)) {
                                return response()->json([
                                    "status" => "error",
                                    "message" => "Personel ".$personel->name." bu tarihte hizmet vermemektedir"
                                ], 200);
                            } else {
                                for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time)->endOfDay(); $i->addMinute($personel->appointmentRange->time)) {
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
                // Value değerlerine göre gruplandır
                $groupedValues = [];
                foreach ($clocks as $item) {
                    $value = $item['value'];
                    if (!isset($groupedValues[$value])) {
                        $groupedValues[$value] = [];
                    }
                    $groupedValues[$value][] = $item['durum'];
                }

                // Tüm personllerin dizide durum değeri true olan value değerlerini topla
                $totalClocks = [];
                foreach ($groupedValues as $value => $statuses) {
                    if (count($statuses) > 1 && !in_array(false, $statuses)) {
                        $totalClocks[] = $value;
                    }
                }

                $clocks = [];

                $appStartTime = Carbon::parse($totalClocks[0]);
                $endTime = Carbon::parse($totalClocks[count($totalClocks) - 1]);

                $clockRange = $appStartTime->diffInMinutes($endTime);
                $totalServiceTime = 0;

                foreach ($serviceIds as $index => $serviceId) {
                    $service = BusinessService::find($serviceId);
                    $totalServiceTime += $service->time;
                }
                if ($clockRange < $totalServiceTime){
                    return response()->json([
                        "status" => "error",
                        "message" => "Seçtiğiniz Hizmetlere Uygun Randevu Aralığı Bulunamadı"
                    ], 200);
                }
                foreach ($totalClocks as $clock){
                    $parsedClock = Carbon::parse($clock);
                    $clocks[] = [
                        'id' => $parsedClock->format('d_m_Y_' . $parsedClock->format('H_i')),
                        'saat' => $parsedClock->format('H:i'),
                        'date' => $parsedClock->format('d.m.Y'),
                        'value' => $parsedClock->format('d.m.Y ' . $parsedClock->format('H:i')),
                        'durum' => true
                    ];
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
