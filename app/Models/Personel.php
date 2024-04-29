<?php

namespace App\Models;

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

    public function appointments()
    {
        return $this->hasMany(AppointmentServices::class, 'personel_id', 'id');
    }

    public function stayOffDays()
    {
        return $this->hasMany(PersonelStayOffDay::class, 'personel_id', 'id');
    }

    public function checkDateIsOff($getDate)
    {
        // stayOffDays ilişkisini kullanarak izin tarihlerini alıyoruz.
        $getDate = Carbon::parse($getDate);
        $offDays = $this->stayOffDays;

        if ($offDays->count() > 0) {
            foreach ($offDays as $day) {
                $startTime = Carbon::parse($day->start_time);
                $endTime = Carbon::parse($day->end_time);
                if ($getDate >= $startTime && $getDate <= $endTime) {
                    return true;
                }
            }
        }
        // Eğer tarih izin tarihleri arasında değilse,false döndürüyoruz.
        return false;
    }
    public function restDays()
    {
        return $this->hasMany(PersonelRestDay::class, 'personel_id', 'id')->where('status', 1);
    }

    public function appointmentRange()
    {
        return $this->hasOne(AppointmentRange::class, 'id', 'range');
    }
}
