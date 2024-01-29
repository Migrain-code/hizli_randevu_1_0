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
        $getDate = Carbon::parse($request->date);
        $business = Business::find($request->business_id);
        $uniqueArray = array_unique($request->personals);
        $personels = [];
        foreach ($uniqueArray as $id) {
            $personels[] = Personel::find($id);
        }
        $newClocks = [];
        foreach ($personels as $personel) {
            $clocks = [];
            $loop = 0;
            $disabledDays = [];
            $disabledDays[] = $this->findTimes($personel);
            for ($i = \Illuminate\Support\Carbon::parse($personel->start_time); $i < \Illuminate\Support\Carbon::parse($personel->end_time); $i->addMinute($personel->range)) {
                if (Carbon::parse($getDate->format('d.m.Y '))->dayOfWeek == $business->off_day) {
                    $clock = [
                        'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                        'saat' => 'İşletme bu tarihte hizmet vermemektedir',
                        'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                        'durum' => false,
                    ];
                    if ($loop == 0) {
                        $clocks[] = $clock;
                    }

                    $loop++;

                } else {
                    if (Carbon::parse($getDate->format('d.m.Y ') . $i->format('H:i')) < Carbon::now()) {
                        $clock = [
                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                            'saat' => $i->format('H:i'),
                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                            'durum' => false,
                        ];
                        $clocks[] = $clock;
                    } else {
                        $clock = [
                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                            'saat' => $i->format('H:i'),
                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays) ? false : true,
                        ];
                        $clocks[] = $clock;
                    }
                }
            }
            $newClocks[] = [
                'personel' => PersonelResource::make($personel),
                'clocks' => $clocks,
            ];

        }

        return response()->json([
            'personel_clocks' => $newClocks,
        ]);

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

                $currentDateTime->addMinutes(intval($personel->range));
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
