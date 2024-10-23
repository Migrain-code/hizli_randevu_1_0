<?php

namespace App\Http\Controllers\Api\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\CheckClockRequest;
use App\Http\Requests\Appointment\CreateRequest;
use App\Http\Requests\Appointment\GetClockRequest;
use App\Http\Requests\Appointment\GetPersonelRequest;
use App\Http\Requests\Appointment\SummaryRequest;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Http\Resources\Business\BusinessListResource;
use App\Http\Resources\Business\BusinessRoomResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\Business;
use App\Models\BusinessCustomer;
use App\Models\BusinessService;
use App\Models\Campaign;
use App\Models\Customer;
use App\Models\Personel;
use App\Models\PersonelRoom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @group Randevu Oluşturma
 *
 */
class AppointmentCreateController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->customer = auth('api')->user();
            return $next($request);
        });
    }

    /**
     * Personel Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPersonel(GetPersonelRequest $request, Business $business)
    {
        $getData = $request->services;
        $room_id = $request->room_id;
        $rooms = [];
        if ($business->rooms->count() > 0) {
            $rooms[] = [
                "id" => 0,
                "name" => "Salon",
                "color" => "#000",
                "percentage" => 0,
            ];
            foreach ($business->rooms as $room) {
                $rooms[] = [
                    "id" => $room->id,
                    "name" => $room->name,
                    "color" => $room->color,
                    "percentage" => $room->price,
                ];
            }
        }
        $ap_services = [];
        foreach ($getData as $id) {
            $service = BusinessService::find($id);
            $servicePersonels = [];
            foreach ($service->personels as $item) {
                if ($item->personel && $item->personel->status == 1) {
                    if ($business->rooms->count() > 0 && isset($room_id)) {
                        $roomPersonelIds = PersonelRoom::where('business_id', $item->personel->business_id)
                            ->where('room_id', $room_id)
                            ->pluck('personel_id')
                            ->toArray();

                        if (in_array($item->personel_id, $roomPersonelIds)) {
                            $servicePersonels[] = [
                                'id' => $item->personel->id,
                                'merged_id' => $item->personel?->id . "_" . $service->id,
                                'name' => $item->personel?->name,
                            ];
                        }
                    } else {
                        $servicePersonels[] = [
                            'id' => $item->personel->id,
                            'merged_id' => $item->personel?->id . "_" . $service->id,
                            'name' => $item->personel?->name,
                        ];
                    }

                }
            }

            $ap_services[] = [
                'id' => $id,
                'title' => $service->subCategory->getName() . " için personel seçiniz",
                'personels' => $servicePersonels,
            ];
        }
        return response()->json([
            'rooms' => $rooms,
            'personels' => $ap_services,

        ]);
    }

    /**
     *
     * Tarih Listesi
     * @param Request $request
     * @return void
     */
    public function getDate()
    {
        $i = 0;
        $remainingDate = [];

        while ($i <= 30) {
            $remainingDate[] = Carbon::now()->addDays($i);
            $i++;
        }

        foreach ($remainingDate as $date) {
            $dateStartOfDay = clone $date;
            $dateStartOfDay->startOfDay();

            $today = Carbon::now()->startOfDay();
            $tomorrow = Carbon::now()->addDays(1)->startOfDay();

            if ($dateStartOfDay->eq($today)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Bugün",
                    'month' => $date->translatedFormat('F'),
                    'text' => "Bugün",
                    'value' => $date->toDateString(),
                ];
            } else if ($dateStartOfDay->eq($tomorrow)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Yarın",
                    'text' => "Yarın",
                    'month' => $date->translatedFormat('F'),
                    'value' => $date->toDateString(),
                ];
            } else {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'month' => $date->translatedFormat('F'),
                    'day' => $date->translatedFormat('l'),
                    'text' => $date->translatedFormat('d F l'),
                    'value' => $date->toDateString(),
                ];
            }
        }

        return response()->json($dates);
    }

    /**
     * Saat Listesi
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getClock(GetClockRequest $request, Business $business)
    {
        $getDate = Carbon::parse($request->appointment_date);
        $personelIds = [];
        $serviceIds = [];
        foreach ($request->personels as $personelId) {
            $personelIds[] = explode('_', $personelId)[0];
            $serviceIds[] = explode('_', $personelId)[1];
        }
        $uniquePersonals = array_unique($personelIds);

        // personelleri gelen id lere göre db den collection olarak al
        $personels = [];
        foreach ($uniquePersonals as $id) {
            $personels[] = Personel::find($id);
        }
        $clocks = [];
        if (count($uniquePersonals) == 1) {
            foreach ($personels as $personel) {

                $disabledDays[] = $this->findTimes($personel, $request->room_id, $getDate);
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
                            "message" => "Personel bu tarihte hizmet vermemektedir"
                        ], 200);
                    } else {
                        //personel kapalı değilse personel izin gün kontrolü
                        $personelRestDay = $personel->checkDateIsOff($getDate);
                        if (isset($personelRestDay) && ($personelRestDay->end_time->format("Y-m-d") != $getDate->format('Y-m-d'))) {
                            return response()->json([
                                "status" => "error",
                                "message" => "Personel bu tarihte hizmet vermemektedir"
                            ], 200);
                        } else {
                            //tüm koşullar sağlanmış ise personel saat takvimi
                            $checkCustomWorkTime = $personel->isCustomWorkTime($request->appointment_date);

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
                                    $lastTime = "";
                                    for ($i = Carbon::parse($checkCustomWorkTime->start_time); $i < Carbon::parse($checkCustomWorkTime->end_time)->endOfDay(); $i->addMinute($personel->appointmentRange->time)) {
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
                    $disabledDays = [];
                    $disabledDays[] = $this->findTimes($personel, $request->room_id, $getDate);
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
                            $personelRestDay = $personel->checkDateIsOff($getDate);
                            if (isset($personelRestDay) && ($personelRestDay->end_time->format("Y-m-d") != $getDate->format('Y-m-d'))) {
                                return response()->json([
                                    "status" => "error",
                                    "message" => "Personel bu tarihte hizmet vermemektedir"
                                ], 200);
                            } else {
                                for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
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

    /**
     * Saat Kontrolü
     * @param Request $request
     * @return JsonResponse
     */
    public function checkClock(CheckClockRequest $request, Business $business)
    {
        $appointmentStartTime = Carbon::parse($request->appointment_time);
        $appointmentId = rand(100000, 999999);
        $personelIds = [];
        $serviceIds = [];
        foreach ($request->personels as $personelId) {
            $personelIds[] = explode('_', $personelId)[0];
            $serviceIds[] = explode('_', $personelId)[1];
        }
        if (count($personelIds) != count($serviceIds)) {
            return response()->json([
                'status' => "error",
                'message' => "Seçilen personel ve hizmet sayıları eşleşmiyor"
            ], 422);
        }
        foreach ($serviceIds as $index => $serviceId) {
            $findService = BusinessService::find($serviceId);
            $appointmentService = new AppointmentServices();
            $appointmentService->personel_id = $personelIds[$index];
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $appointmentStartTime;
            $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time)->format('Y-m-d H:i:s');
            $appointmentService->appointment_id = $appointmentId;
            //$appointmentService->save();
            /**------------------Saat Kontrolü------------------*/
            $result = $this->checkPersonelClock($request->personels[$index], $appointmentService->start_time, $appointmentService->end_time);

            if ($result) {

                return response()->json([
                    'status' => "error",
                    'message' => "Seçtiğiniz saate " . $findService->time . " dakikalık hizmet seçtiniz. Bu saate randevu alamazsınız. Başka bir saat seçmelisiniz."
                ], 422);
            }

        }
        return response()->json([
            'status' => "success",
            'message' => "Saat seçim işleminiz onaylandı. Müşteri Seçebilirsiniz"
        ]);

    }

    /**
     * Kampanya Kodu Uygula
     *
     * @urlParam campaign_code
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function useCoupon(Request $request)
    {
        $campaign = Campaign::where('code', $request->input('campaign_code'))->first();
        if (isset($campaign)){
            $existCustomerList = $campaign->customers()->where('customer_id', $this->customer->id)->exists();
            if ($existCustomerList){
                return response()->json([
                   'status' => "success",
                   'message' => "Kampanya İndirimi Başarılı Bir Şekilde Uygulandı",
                   'campaign_id' => $campaign->id,
                ]);
            } else{
                return response()->json([
                    'status' => "success",
                    'message' => "Kampanya Kodunu Hatalı veya Yanlış Tuşladınız"
                ], 422);
            }
        }
        return response()->json([
            'status' => "success",
            'message' => "Kampanya Kodunu Hatalı veya Yanlış Tuşladınız"
        ], 422);
    }
    /**
     * Randevu Özeti
     *
     * @param Request $request
     * @param Business $business
     * @return JsonResponse
     */
    public function summary(SummaryRequest $request, Business $business)
    {
        $servicePrices = [];
        $isCalculate = [];
        $room_id = $request->room_id;
        $total = 0;
        foreach ($request->personels as $personelId) {
            $service = BusinessService::find(explode('_', $personelId)[1]);

            $personelPrice = $service->getPersonelPrice(explode('_', $personelId)[0]);
            if ($service->price_type_id == 1) {
                if (isset($personelPrice)) {
                    $calculatedServicePrice = $personelPrice?->price;
                    if (is_numeric($calculatedServicePrice)) {
                        $total += $calculatedServicePrice;
                    } else {
                        $isCalculate[] = 1;
                    }
                } else {
                    $calculatedServicePrice = $service->price. " - ". $service->max_price;
                    $isCalculate[] = 1;
                }
            } else {

                $calculatedServicePrice = $service->getPrice($room_id, $personelPrice?->price);

                $total += $calculatedServicePrice;
            }


            $servicePrices [] = [
                "id" => $service->id,
                "name" => $service->subCategory->getName(),
                "price" => str($calculatedServicePrice),
            ];

        }
        $discount = 0;
        $generalTotal = $total;
        if (isset($request->campaign_id)){
            $campaign = Campaign::find($request->campaign_id);
            $discount = $campaign->discount;
            if (is_numeric($total)){
                $discount = ($total * $discount) / 100; // indirim tutarı
                $total -= $discount; //indirimli tutar
            }
        }

        return response()->json([
            'businessName' => $business->name,
            'date' => Carbon::parse($request->appointment_time)->translatedFormat('d F Y'),
            'clock' => Carbon::parse($request->appointment_time)->translatedFormat('H:i'),
            'prices' => $servicePrices,
            'discount' => $discount,
            'generalTotal' => !in_array(1, $isCalculate) ? str($generalTotal) : "Hesaplanacak",
            'total' => !in_array(1, $isCalculate) ? str($total) : "Hesaplanacak",
        ]);
    }

    /**
     *
     * Randevu Oluştur
     * @param Request $request
     * @return JsonResponse
     */
    public function appointmentCreate(CreateRequest $request, Business $business)
    {
        $appointment = new Appointment();
        $appointment->customer_id = $this->customer->id;
        $appointment->business_id = $business->id;
        $appointment->room_id = $request->room_id == 0 ? null : $request->room_id;
        $appointment->save();

        $personelIds = [];
        $serviceIds = [];
        foreach ($request->personels as $personelId) {
            $personelIds[] = explode('_', $personelId)[0];
            $serviceIds[] = explode('_', $personelId)[1];
        }

        $appointmentStartTime = Carbon::parse($request->appointment_time);
        $approve_types = [];
        foreach ($serviceIds as $index => $serviceId) {
            $findService = BusinessService::find($serviceId);
            if($findService){
                $appointmentService = new AppointmentServices();
                $appointmentService->personel_id = $personelIds[$index];
                $appointmentService->service_id = $serviceId;
                $appointmentService->start_time = $appointmentStartTime;
                $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time);
                $appointmentService->appointment_id = $appointment->id;
                $appointmentService->save();

                $result = $this->checkPersonelClock($request->personels[$index], $appointmentService->start_time, $appointmentService->end_time, $appointment->id);

                if ($result) {
                    $appointment->services()->delete();
                    $appointment->delete();
                    return response()->json([
                        'status' => "error",
                        'message' => "Üzgünüz, seçmiş olduğunuz randevu saati doludur. Lütfen farklı bir saat seçmeyi deneyin ya da bir süre sonra tekrar kontrol edin."
                    ], 422);

                } else{
                    $approve_types[] = $findService->approve_type;
                }
            }


        }

        $appointment->start_time = $appointment->services()->first()->start_time;
        $appointment->end_time = $appointment->services()->skip($appointment->services()->count() - 1)->first()->end_time;
        $calculateTotal = $appointment->calculateTotal();
        $appointment->total = $calculateTotal;
        if (in_array(1, $approve_types)) { // hizmet maneul onay ise
            $appointment->status = 0; // Otomatik onay
            foreach ($appointment->services as $service) {
                $service->status = 0;
                $service->save();
            }
            $message = $business->name . " İşletmesine Randevunuz talebiniz alınmıştır. İşletmemiz en kısa sürede sizi bilgilendirecektir.";

        } else {
            $appointment->status = 1; // Otomatik onay ise
            foreach ($appointment->services as $service) {
                $service->status = 1;
                $service->save();
            }
            $message = $business->name . " İşletmesine " . $appointment->start_time->format('d.m.Y H:i') . " tarihine randevunuz oluşturuldu.";

        }
        $appointment->location = "Hızlı Randevu Mobil";
        if ($appointment->save()) {
            if (isset($request->campaign_id)){
                $campaign = Campaign::find($request->campaign_id);
                $discount = $campaign->discount;
                $appointment->campaign_id = $request->campaign_id;
                $appointment->discount = $discount;
                $appointment->save();
            }
            //$appointment->customer->sendSms($message);
            $title = "Randevunuz Oluşturuldu";
            $appointment->customer->sendNotification($title, $message);
            $appointment->sendPersonelNotification();
            $appointment->sendOfficialCreateNotification();
            $appointment->scheduleReminder();
            $appointment->calculateTotal();
            $existCustomer = $business->customers()->where('customer_id', $appointment->customer_id)->first();
            if (!isset($existCustomer)){
                $businessCustomer = new BusinessCustomer();
                $businessCustomer->business_id = $business->id;
                $businessCustomer->customer_id = $appointment->customer_id;
                $businessCustomer->type = 0;
                $businessCustomer->status = 1;
                $businessCustomer->save();
            }
            return response()->json([
                'status' => "success",
                'message' => "Randevunuz başarılı bir şekilde oluşturuldu",
                'appointment' => AppointmentResource::make($appointment),
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Bir hata sebebiyle randevunuz oluşturulamadı lütfen tekrar deneyiniz",
        ], 422);
    }
    public function findDisabledTimes($personel, $appointmentStartTime, $appointmentId = null)
    {
        $appointments = $personel->appointments()
            ->when(isset($appointmentId), function ($q) use ($appointmentId){
                $q->whereNotIn('appointment_id', [$appointmentId]);
            })
            ->whereDate('start_time', $appointmentStartTime->toDateString())
            ->whereNotIn('status', [3])
            ->get();
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
        return $disabledTimes;
    }

    public function checkPersonelClock($personelId, $startTime, $endTime, $appointmentId = null)
    {

        $findPersonel = Personel::find($personelId);
        $disabledTimes = $this->findDisabledTimes($findPersonel, $startTime, $appointmentId);

        $disableds = [];
        $currentDateTime = $startTime->copy();

        while ($currentDateTime < $endTime) {
            $disableds[] = $currentDateTime->format('d.m.Y H:i');
            $currentDateTime->addMinutes(intval($findPersonel->appointmentRange->time));
        }

        foreach ($disableds as $disabledTime) {
            if (in_array($disabledTime, $disabledTimes)) {
                return true;
            }
        }

        return false;
    }

    public function findTimes($personel, $room_id, $appointment_date = null)
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
        for ($i = $startTime; $i < $endTime; $i->addMinutes(intval($personel->appointmentRange->time))) {
            if ($i < now()->addMinutes(5)) {
                $disableds[] = $i->format('d.m.Y H:i');
            }
        }
        if (isset($appointment_date)){
            //personel izin saatlerini de ekle
            $offDays = $personel->stayOffDays()
                ->whereDate('start_time', '<=', Carbon::parse($appointment_date))
                ->whereDate('end_time', '>=', Carbon::parse($appointment_date))->get();

            foreach ($offDays as $offDay) {
                $leaveStart = Carbon::parse($offDay->start_time);
                $leaveEnd = Carbon::parse($offDay->end_time);

                $leaveDateTime = $leaveStart->copy();
                while ($leaveDateTime < $leaveEnd) {
                    $disableds[] = $leaveDateTime->format('d.m.Y H:i');
                    $leaveDateTime->addMinutes(intval($personel->appointmentRange->time));
                }
            }
        }

        $business = $personel->business;
        if (isset($room_id) && $room_id > 0) {
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


}
