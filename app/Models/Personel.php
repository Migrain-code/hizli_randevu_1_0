<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasOne(PersonelStayOffDay::class, 'personel_id', 'id');
    }

    public function checkDateIsOff($getDate)
    {
        // stayOffDays ilişkisini kullanarak izin tarihlerini alıyoruz.
        $offDays = $this->stayOffDays;

        if ($getDate >= $offDays->start_time && $getDate <= $offDays->end_time) {
            return true;
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
