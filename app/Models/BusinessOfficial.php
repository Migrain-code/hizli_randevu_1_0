<?php

namespace App\Models;

use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class BusinessOfficial extends Model
{
    public function userType()
    {
        return $this->is_admin ==  1 ? "Admin" : "Yetkili";
    }
    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id')->withDefault([
            'name' => "İşletme Bulunamadı"
        ]);
    }
    public function permission()
    {
        return $this->hasOne(BusinessNotificationPermission::class, 'business_id', 'id');
    }
    public function devicePermission()
    {
        return $this->hasOne(BusinessDeviceNotificationPermission::class, 'business_id', 'id');
    }
    public function device()
    {
        return $this->hasOne(Device::class, 'customer_id', 'id')->where('type', 3);
    }
    public function notifications()
    {
        return $this->hasMany(BusinessNotification::class, 'business_id', 'id');
    }
    public function menuNotifications()
    {
        return $this->notifications()->where('status', 0)->latest()->take(10);
    }

    public function personelAccount()
    {
        return Personel::where('phone', clearPhone($this->phone))->first();
    }
    public function sendNotification($title, $message)
    {
        $notification = new BusinessNotification();
        $notification->business_id = $this->id;
        $notification->type = 0;
        $notification->title = $title;
        $notification->message = $message;
        $notification->status = 0;
        $notification->link = uniqid();
        $notification->save();

        if (isset($this->device)){
            NotificationService::sendPushNotification($this->device->token, $title, $message);
        }
        return true;
    }
    public function sendWelcomeMessage()
    {
        $notification = new BusinessNotification();
        $notification->business_id = $this->id;
        $notification->type = 0;
        $notification->title = "Merhaba ". $this->name;
        $notification->message = "
                Hızlı Randevu Rezervasyon Programımıza hoş geldiniz! Kaydınız başarıyla tamamlandı ve artık sistemimizi kullanmaya hazırsınız.
                Programımızı kullanarak kolayca randevu oluşturabilir, mevcut randevularınızı görüntüleyebilir ve yönetebilirsiniz. Ayrıca, size uygun olan tarih ve saatlerde randevu hatırlatıcıları alabilirsiniz.
                Programımız hakkında herhangi bir sorunuz veya geri bildiriminiz olursa, lütfen çekinmeden bizimle iletişime geçin. Size yardımcı olmaktan mutluluk duyarız.
                Saygılarımızla,
                Hızlı Randevu Ekibi 🙂
                ";
        $notification->link = uniqid();
        $notification->save();
    }

}
