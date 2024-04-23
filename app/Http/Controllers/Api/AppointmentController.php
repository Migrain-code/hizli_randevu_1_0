<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Resources\PersonelResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\Business;
use App\Models\BusinessService;
use App\Models\Customer;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @group Appointment
 */
class AppointmentController extends Controller
{
    public function getClock(Request $request)
    {
        header("Access-Control-Allow-Origin: *");
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
                        'value' => $getDate->format('d.m.Y '),
                        'durum' => false,
                    ];
                } else {
                    if (in_array(Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek, $personel->restDays()->pluck('day_id')->toArray())) {
                        $clocks[] = [
                            'id' => $getDate->format('d_m_Y_'),
                            'saat' => 'Personel bu tarihte hizmet vermemektedir',
                            'value' => $getDate->format('d.m.Y '),
                            'durum' => false,
                        ];
                    } else {
                        if ($personel->checkDateIsOff($getDate)) {
                            $clocks[] = [
                                'id' => $getDate->format('d_m_Y_'),
                                'saat' => 'Personel ' . Carbon::parse($personel->stayOffDays->start_time)->format('d.m.Y H:i') . " tarihinden " . Carbon::parse($personel->stayOffDays->end_time)->format('d.m.Y H:i') . " Tarihine Kadar İzinlidir",
                                'value' => $getDate->format('d.m.Y '),
                                'durum' => false,
                            ];
                        } else {
                            for ($i = \Illuminate\Support\Carbon::parse($personel->start_time); $i < \Illuminate\Support\Carbon::parse($personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                $clocks[] = [
                                    'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                    'saat' => "ad",
                                    'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                    'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays) ? false : true,
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
                    'value' => $getDate->format('d.m.Y '),
                    'durum' => false,
                ];
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
                        'saat' => "asd",
                        'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                        // işletmenin çalışma saatleri ile personelin çalışma saatlerini karşılaştır aynı olanları false yap
                        'durum' => !in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledTimes),
                    );
                }
                $found = false;
                $startTime = null;
                $currentTime = null;
                $totalTime =  0;
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
                        $totalTime =  0; // Boş alan başladığında toplam süreyi sıfırlayın
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

    public function appointmentCreate(CreateAppointmentRequest $request)
    {
        $business = Business::find($request->business_id);
        if ($request->user('customer')) {
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

        if ($loop > 1) {
            $appointment->end_time = Carbon::parse($request->input('appointment_date') . ' ' . $end)->format('d.m.Y H:i');
        } else {
            $appointment->end_time = Carbon::parse($request->input('appointment_date') . ' ' . $start)->addMinutes($sumTime)->format('d.m.Y H:i');
        }

        $appointment->save();
        return [
            'status' => 'success',
            'message' => ''
        ];
    }
}
