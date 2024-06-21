<?php

namespace App\Models;

use App\Services\NotificationService;
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
        return $this->hasOne(Device::class, 'customer_id', 'id')->where('type', 1);
    }

    public function campaigns()
    {
        return $this->hasMany(CampaignCustomer::class, 'customer_id', 'id')->whereHas('campaign', function ($q){
            $q->whereStatus(1);
        });
    }
    public function notifications()
    {
        return $this->hasMany(CustomerNotificationMobile::class, 'customer_id', 'id')->latest()->orderBy('status', 'asc');
    }
    public function unReadNotifations()
    {
        return $this->notifications()->where('status', 0);
    }
    public function permissions()
    {
        return $this->hasOne(CustomerNotificationPermission::class, 'customer_id', 'id');
    }

    public function checkPermissions()
    {
        if (!isset($this->permissions)){
            $permission = new CustomerNotificationPermission();
            $permission->customer_id = $this->id;
            $permission->save();
        }
    }
    public function favorites()
    {
        return $this->hasMany(CustomerFavorite::class, 'customer_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(ProductSales::class, 'customer_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany(BusinessComment::class, 'customer_id', 'id');
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
    public function sendNotification($title, $message, $iconId = 1)
    {
        $notification = new CustomerNotificationMobile();
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
    public function getMonthlyPackageSales()
    {
        $sales = [];
        for ($i = 1; $i <= 12; $i++) {
            $sales[] = $this->packets()->whereMonth('seller_date', $i)->count();
        }
        return $sales;
    }

    public function getMonthlyProductSales()
    {
        $sales = [];
        for ($i = 1; $i <= 12; $i++) {
            $sales[] = $this->orders()->whereMonth('created_at', $i)->sum('piece');
        }
        return $sales;
    }
}
