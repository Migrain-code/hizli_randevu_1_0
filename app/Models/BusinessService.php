<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessService extends Model
{
    use HasFactory;

    public function gender()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'type');
    }

    public function categorys()
    {
        return $this->hasOne(ServiceCategory::class, 'id', 'category');
    }

    public function subCategory()
    {
        return $this->hasOne(ServiceSubCategory::class, 'id', 'sub_category');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id','business_id');
    }

    public function personels()
    {
        return $this->hasMany(PersonelService::class, 'service_id', 'id');
    }

    public function getPrice($room_id = null)
    {
        $price = 0;
        if (isset($room_id)){
            $findRoom = $this->business->rooms()->where('id', $room_id)->first();
            if ($findRoom){
                $price = $this->price + (($this->price * $findRoom->price) / 100);
            } else{
                $price = $this->price;
            }
        } else{
            $price = $this->price_type_id == 0 ? $this->price : $this->price . " - " . $this->max_price;
        }

        return $price;
    }

    public function getPersonelPrice($personelId)
    {
        return $this->hasOne(PersonelCustomerPriceList::class ,'business_service_id', 'id')->where('personel_id', $personelId)->first();
    }
}
