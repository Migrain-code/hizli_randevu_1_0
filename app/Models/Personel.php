<?php

namespace App\Models;

use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Personel extends Model
{
    use HasFactory;

    public function type()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'gender');
    }

    public function services()
    {
        return $this->hasMany(PersonelService::class, 'personel_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(ActivityBusiness::class, 'personel_id', 'id');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');

    }
    public function device()
    {
        return $this->hasOne(Device::class, 'customer_id', 'id')->where('type', 2);
    }
    public function sendNotification($title, $message, $iconId = 1)
    {
        $notification = new PersonelNotification();
        $notification->notification_id = $iconId;
        $notification->title = $title;
        $notification->content = $message;
        $notification->status = 0;
        $notification->slug = uniqid();
        $notification->customer_id = $this->id;
        $notification->save();

        if (isset($this->device)){
            NotificationService::sendPushNotification($this->device->token, $title, $message);
        }
        return true;
    }
    public function appointments()
    {
        return $this->hasMany(AppointmentServices::class, 'personel_id', 'id');
    }

    public function stayOffDays()
    {
        return $this->hasMany(PersonelStayOffDay::class, 'personel_id', 'id');
    }
    public function checkDayControl($personel_id, $secilen_tarih_baslangic, $secilen_tarih_bitis)
    {
        return PersonelStayOffDay::where('personel_id', $personel_id)
            ->where(function($query) use ($secilen_tarih_baslangic, $secilen_tarih_bitis) {
                $query->whereBetween('start_time', [$secilen_tarih_baslangic, $secilen_tarih_bitis])
                    ->orWhereBetween('end_time', [$secilen_tarih_baslangic, $secilen_tarih_bitis]);
            })
            ->exists();
    }
    public function checkDateIsOff($getDate)
    {
        // stayOffDays ilişkisini kullanarak izin tarihlerini alıyoruz.
        $getDate = Carbon::parse($getDate)->format('Y-m-d');
        $offDays = $this->stayOffDays();
        if ($offDays->count() > 0) {
            $existLeave = $offDays->whereDate('start_time', '<=', $getDate)
                ->whereDate('end_time', '>=', $getDate)
                ->first();
            if ($existLeave) {
                return true;
            }
        }
        // Eğer tarih izin tarihleri arasında değilse,false döndürüyoruz.
        return false;
    }
    public function restDays()
    {
        return $this->hasMany(PersonelRestDay::class, 'personel_id', 'id')->where('status', 1);
    }
    public function restDayAll()
    {
        return $this->hasMany(PersonelRestDay::class, 'personel_id', 'id');
    }
    public function appointmentRange()
    {
        return $this->hasOne(AppointmentRange::class, 'id', 'range');
    }

    public function workTimes()
    {
        return $this->hasMany(PersonelWorkTime::class, 'personel_id', 'id');
    }

    public function activeWorkTimes()
    {
        return $this->workTimes()->where('status', 1);
    }

    public function isCustomWorkTime($date)
    {
        $closeDate = Carbon::parse($date);
        $personelWorkTimes = $this->activeWorkTimes;

        $isClosed = $personelWorkTimes->first(function ($closeDateRecord) use ($closeDate) {
            $startTime = Carbon::parse($closeDateRecord->start_date);
            $endTime = Carbon::parse($closeDateRecord->end_date);

            return $closeDate->between($startTime, $endTime);
        });

        return $isClosed;
    }
}
