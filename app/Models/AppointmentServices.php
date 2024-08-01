<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentServices extends Model
{
    use HasFactory;

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'id', 'appointment_id');
    }
    public function service()
    {
        return $this->hasOne(BusinessService::class, 'id', 'service_id');
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
    public function getPersonelPrice()
    {
        return $this->hasOne(PersonelCustomerPriceList::class ,'business_service_id', 'service_id')->where('personel_id', $this->personel_id);
    }
    public function servicePrice()
    {
        $service = $this->service;
        $personelPrice = $this->getPersonelPrice;

        if ($service->price_type_id == 1 && $this->total == 0){ // aralıklı fiyatsa
            return $service->price. " TL - ". $service->max_price. " TL";
        } else{

            if ($this->total > 0){

                if (isset($this->appointment->room_id) && $this->appointment->room_id > 0) {
                    $room = $this->appointment->room;

                    if ($room->increase_type == 0) { // tl fiyat arttırma
                        $servicePrice = $this->total + $room->price;
                    } else { // yüzde fiyat arttırma
                        $servicePrice = $this->total + (($this->total * $room->price) / 100);

                    }
                } else {
                    $servicePrice = $this->total;
                }
            } else{

                if (isset($this->appointment->room_id) && $this->appointment->room_id > 0) {

                    $room = $this->appointment->room;

                    if ($room->increase_type == 0) { // tl fiyat arttırma
                        $servicePrice = $service->price + $room->price;
                    } else { // yüzde fiyat arttırma

                        if (isset($personelPrice)){
                            $servicePrice = $personelPrice->price + (($personelPrice->price * $room->price) / 100);
                        } else{
                            $servicePrice = $service->price + (($service->price * $room->price) / 100);
                        }
                    }
                } else {
                    $servicePrice = $service->price;
                }
            }

        }

        return $servicePrice;
    }
}
