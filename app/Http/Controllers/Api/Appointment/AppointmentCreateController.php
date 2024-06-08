<?php

namespace App\Http\Controllers\Api\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\CheckClockRequest;
use App\Http\Requests\Appointment\GetClockRequest;
use App\Http\Requests\Appointment\GetPersonelRequest;
use App\Http\Requests\Appointment\SummaryRequest;
use App\Http\Resources\Business\BusinessRoomResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\Business;
use App\Models\BusinessService;
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
                    if (isset($room_id)) {
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

                $disabledDays[] = $this->findTimes($personel, $request->room_id);
                //işletme kapalı gün kontrolü
                if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                    return response()->json([
                        "status" => "error",
                        "message" => "İşletme bu tarihte hizmet vermemektedir"
                    ], 422);
                } else {
                    //işletme kapalı değilse personel izin kontrolü
                    if (in_array(Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek, $personel->restDays()->pluck('day_id')->toArray())) {
                        return response()->json([
                            "status" => "error",
                            "message" => "Personel bu tarihte hizmet vermemektedir"
                        ], 422);
                    } else {
                        //personel kapalı değilse personel izin gün kontrolü
                        if ($personel->checkDateIsOff($getDate)) {
                            return response()->json([
                                "status" => "error",
                                "message" => "Personel bu tarihte hizmet vermemektedir"
                            ], 422);
                        } else {
                            //tüm koşullar sağlanmış ise personel saat takvimi
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

        } else { // birden fazla ve farklı personel seçilmişse

            if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                return response()->json([
                    "status" => "error",
                    "message" => "İşletme bu tarihte hizmet vermemektedir"
                ], 422);
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
                foreach ($serviceIds as $serviceId) {
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
                        "message" => "Seçtiğiniz Hizmetler için uygun randevu aralığı bulunmamaktadır. Randevu Gününü,Personeli veya Hizmeti Değiştirerek Yeniden Saat Arayabilirsiniz."
                    ], 422);
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
                ]);
            }

        }
        return response()->json([
            'status' => "success",
            'message' => "Saat seçim işleminiz onaylandı. Müşteri Seçebilirsiniz"
        ]);
        /*if ($this->checkPersonelClock($request->personel_id, $appointmentService->start_time, $appointmentService->end_time, $appointment->id)) {

        }*/
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

        return response()->json([
            'businessName' => $business->name,
            'date' => Carbon::parse($request->appointment_time)->translatedFormat('d F Y'),
            'clock' => Carbon::parse($request->appointment_time)->translatedFormat('H:i'),
            'prices' => $servicePrices,
            'total' => !in_array(1, $isCalculate) ? str($total) : "Hesaplanacak",
        ]);
    }

    /**
     * Randevu oluşturma
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function appointmentCreate(Request $request, Business $business)
    {
        $appointment = new Appointment();
        $appointment->business_id = $business->id;
        $appointment->customer_id = $this->customer->id;
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
            return response()->json([
                'status' => "success",
                'message' => $message,
            ]);
        }
        return response()->json([
            'status' => "success",
            'message' => "Bir hata sebebiyle randevunuz oluşturulamadı lütfen tekrar deneyiniz"

        ]);
    }


    public function findDisabledTimes($personel, $appointmentStartTime)
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
        return $disabledTimes;
    }

    public function checkPersonelClock($personelId, $startTime, $endTime)
    {

        $findPersonel = Personel::find($personelId);
        $disabledTimes = $this->findDisabledTimes($findPersonel, $startTime);

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
        for ($i = $startTime; $i < $endTime; $i->addMinutes(intval($personel->appointmentRange->time))) {
            if ($i < now()->addMinutes(5)) {
                $disableds[] = $i->format('d.m.Y H:i');
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
