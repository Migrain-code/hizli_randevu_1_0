<?php

namespace App\Models;

use App\Services\Sms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;


class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $guarded = [];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'customer_id', 'id');
    }

    public function device()
    {
        return $this->hasOne(Device::class, 'customer_id', 'id');
    }

    public function campaigns()
    {
        return $this->hasMany(CampaignCustomer::class, 'customer_id', 'id');
    }
    public function notifications()
    {
        return $this->hasMany(CustomerNotificationMobile::class, 'customer_id', 'id')->latest()->orderBy('status', 'asc');
    }

    public function permissions()
    {
        return $this->hasOne(CustomerNotificationPermission::class, 'customer_id', 'id');
    }

    public function favorites()
    {
        return $this->hasMany(CustomerFavorite::class, 'customer_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(ProductSales::class, 'customer_id', 'id');
    }

    public function packets()
    {
        return $this->hasMany(PackageSale::class, 'customer_id', 'id');
    }
    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id')->withDefault([
            'id' => 1,
            'name' => "Konum Bulunamadı"
        ]);
    }
    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id')->withDefault([
            'id' => 1,
            'name' => "Konum Bulunamadı"
        ]);
    }

    public function sendSms($message)
    {
        Sms::send(clearPhone($this->phone), $message);
        return true;
    }

}
