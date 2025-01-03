<?php

namespace App\Models;

use App\Jobs\SendCommentMessageJob;
use App\Jobs\SendReminderJob;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int|null $business_id
 * @property int|null $customer_id
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int|null $status
 * @property float $total
 * @property int $discount
 * @property int|null $campaign_id
 * @property float $point
 * @property float $earned_point kazanılan puan
 * @property string|null $note
 * @property int $comment_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_verify_phone
 * @property-read \App\Models\Business|null $business
 * @property-read \App\Models\CustomerCashPoint|null $cashPoint
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentCollectionEntry> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentPhoto> $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentReceivable> $receivables
 * @property-read int|null $receivables_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSales> $sales
 * @property-read int|null $sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentServices> $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCommentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereEarnedPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereIsVerifyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Appointment extends Model
{
    use HasFactory;

    protected $casts = ['start_time' => "datetime", 'end_time' => "datetime"];
    protected $fillable = ["comment_status"];
    const STATUS_LIST = [
        0 => [
            'html' => '<span class="badge bg-warning text-white fw-bolder px-2 py-2" style="color:#fff04f">Onay Bekliyor</span>',
            'text' => 'Onay Bekliyor',
            "color" => "#fff04f"
        ],
        1 => [
            'html' => '<span class="badge bg-success text-white fw-bolder px-2 py-2">Onaylandı</span>',
            'text' => 'Onaylandı',
            "color" => "#6aab73"
        ],
        2 => [
            'html' => '<span class="badge bg-success text-white fw-bolder px-2 py-2">Tamamlandı</span>',
            'text' => 'Tamamlandı',
            "color" => "#4a7750"
        ],
        3 => [
            'html' => '<span class="badge bg-danger text-white fw-bolder px-2 py-2">İptal Edildi</span>',
            'text' => 'İptal Edildi',
            "color" => "#bf0d36"
        ],
        4 => [
            'html' => '<span class="badge bg-info text-white fw-bolder px-2 py-2">Gelmedi</span>',
            'text' => 'Gelmedi',
            "color" => "#bf0d36"
        ],
        5 => [
            'html' => '<span class="badge bg-success text-white fw-bolder px-2 py-2">Geldi</span>',
            'text' => 'Geldi',
            "color" => "#4a7750"
        ],
        6 => [
            'html' => '<span class="badge bg-warning text-white fw-bolder px-2 py-2">Tahsilatsız Kapatıldı</span>',
            'text' => 'Tahsilatsız Kapatıldı',
            "color" => "#2f4aaf"
        ],

    ];

    public function status($type)
    {
        return self::STATUS_LIST[$this->status][$type] ?? null;
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id')->withDefault([
            'name' => "Silinmiş Müşteri"
        ]);
    }

    public function campaign()
    {
        return $this->hasOne(Campaign::class, 'id', 'campaign_id');
    }

    public function room()
    {
        return $this->hasOne(BusinessRoom::class, 'id', 'room_id');
    }

    public function services()
    {
        return $this->hasMany(AppointmentServices::class, 'appointment_id', 'id');
    }
    public function customerReminderMessage()
    {
        $message = SystemMessage::find(11)->message;
        $serviceName="";
        foreach ($this->services as $service) {
            $serviceName .= sprintf(
                "%s - %s | %s\n ➤ Personel: %s\n",
                $service->start_time->format('H:i'),
                $service->end_time->format('H:i'),
                $service->service->subCategory->getName(),
                $service->personel->name // Personel adını buradan alıyoruz
            );
        }
        $customerMessage = sprintf(
            $message,
            $this->customer->name,
            $this->business->name,
            $this->business->phone,
            $this->start_time->translatedFormat('d F Y'),
            $this->start_time->format('H:i'), // Saat
            $serviceName,
            $this->status('text'),
            createLink($this->business->lat, $this->business->longitude)
        );
        $this->customer->sendSms($customerMessage);
        return $customerMessage;
    }
    public function createCancelSms()
    {
        $message = SystemMessage::find(13)->message;
        $serviceName="";
        foreach ($this->services as $service) {
            $serviceName .= sprintf(
                "%s - %s | %s\n ➤ Personel: %s\n",
                $service->start_time->format('H:i'),
                $service->end_time->format('H:i'),
                $service->service->subCategory->getName(),
                $service->personel->name // Personel adını buradan alıyoruz
            );
        }
        $customerMessage = sprintf(
            $message,
            $this->customer->name,
            $this->business->name,
            $this->start_time->translatedFormat('d F Y'),
            $this->start_time->format('H:i'), // Saat
            $serviceName,
            $this->status('text'),
        );
        $this->customer->sendSms($customerMessage);
        return $customerMessage;
    }
    public function createCustomerSms($id = 1)
    {
        $message = SystemMessage::find($id)->message;
        $serviceName="";
        foreach ($this->services as $service) {
            $serviceName .= sprintf(
                "%s - %s | %s\n ➤ Personel: %s\n",
                $service->start_time->format('H:i'),
                $service->end_time->format('H:i'),
                $service->service->subCategory->getName(),
                $service->personel->name // Personel adını buradan alıyoruz
            );
        }
        $customerMessage = sprintf(
            $message,
            $this->customer->name,
            $this->business->name,
            $this->business->phone,
            $this->start_time->translatedFormat('d F Y'),
            $this->start_time->format('H:i'), // Saat
            $serviceName,
            $this->status('text'),
            createLink($this->business->lat, $this->business->longitude)
        );
        $this->customer->sendSms($customerMessage);
        return $customerMessage;
    }
    public function createCancelNotification($message)
    {
        $this->customer->sendNotification('Randevunuz Sizin Tarafınızdan İptal Edildi', $message);
    }

    public function sendPersonelNotification()
    {
        foreach ($this->services as $service){
            $personelNotification = new PersonelNotification();
            $personelNotification->business_id = $this->business_id;
            $personelNotification->personel_id = $service->personel_id;
            $personelNotification->title = "Merhaba ".$service->personel->name." ,Yeni bir randevunuz var!";
            $personelNotification->message = $this->customer->name. " "." adlı müşteriniz sizden ". $service->start_time. " tarihine ".$service->service->subCategory->getName()." hizmetine randevu aldı.";
            $personelNotification->link = uniqid();
            $personelNotification->save();

            if (isset($service->personel->device)){
                NotificationService::sendPushNotification($service->personel->device->token, $personelNotification->title, $personelNotification->message);
            }
        }
    }
    public function sendOfficialCreateNotification()
    {
        $official = $this->business->official;
        if (isset($official) && isset($official->devicePermission)){

            if ($official->devicePermission->is_all == 1){
                //herkese alınan randevular için bildirimler
                foreach ($this->services as $service){
                    $title = "İşletmenize Bir Randevu Alındı";
                    $message = sprintf(
                        '%s adlı müşteriniz, %s personelinize %s tarihine %s hizmetine randevu aldı.',
                        $this->customer->name,
                        $service->personel->name,
                        $service->start_time->format('d.m.Y H:i'),
                        $service->service->subCategory->getName()
                    );
                    $official->sendNotification($title, $message);
                }
            }
            if ($official->devicePermission->is_me == 1){
                $personel = $official->personelAccount();
                if (isset($personel)){
                    foreach ($this->services as $service){
                        if ($service->personel_id == $personel->id){
                            $title = "Personel Hesabınıza Bir Randevu Alındı";
                            $message = sprintf(
                                '%s adlı müşteriniz, %s personel hesabınıza %s tarihine %s hizmetine randevu aldı.',
                                $this->customer->name,
                                $service->personel->name,
                                $service->start_time->format('d.m.Y H:i'),
                                $service->service->subCategory->getName()
                            );
                            $official->sendNotification($title, $message);
                        }
                    }
                }
            }

        }

    }
    public function sendPersonelCancelNotification()
    {
        foreach ($this->services as $service){
            $personelNotification = new PersonelNotification();
            $personelNotification->business_id = $this->business_id;
            $personelNotification->personel_id = $service->personel_id;
            $personelNotification->title = "Randevu İptali";
            $personelNotification->message = $this->customer->name. " "." adlı müşteriniz sizden ". $service->start_time. " tarihine ".$service->service->subCategory->getName()." aldığı randevuyu iptal etti.";
            $personelNotification->link = uniqid();
            $personelNotification->save();

            if (isset($service->personel->device)){
                NotificationService::sendPushNotification($service->personel->device->token, $personelNotification->title, $personelNotification->message);
            }
        }
    }

    public function payments()
    {
        return $this->hasMany(AppointmentCollectionEntry::class, 'appointment_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany(AppointmentPhoto::class, 'appointment_id', 'id');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function cashPoint()
    {
        return $this->hasOne(CustomerCashPoint::class, 'appointment_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(ProductSales::class, 'appointment_id', 'id');
    }

    public function receivables()
    {
        return $this->hasMany(AppointmentReceivable::class, 'appointment_id', 'id');
    }

    public function addCashPoint()
    {
        if (isset($this->cashPoint)) {
            return false;
        }

        $customerCashPoint = new CustomerCashPoint();
        $customerCashPoint->appointment_id = $this->id;
        $customerCashPoint->customer_id = $this->customer_id;
        $customerCashPoint->business_id = $this->business_id;
        $customerCashPoint->price = $this->earned_point;
        $customerCashPoint->addition_date = now();
        if ($customerCashPoint->save()) {
            return true;

        }
    }

    public function calculateAppointmentEarnedPoint()
    {
        $promossion = $this->business->promossions;
        $discountRate = 0;
        $discountRate = $promossion->cash;

        //dd($discountRate);
        $discountTotal = ($this->calculateTotal() * $discountRate) / 100;
        return $discountTotal;

    }

    public function calculateTotal() // toplam hizmet hiyatı
    {
        $total = 0;
        $rangePrice = false;
        foreach ($this->services as $service) {
            $servicePrice = $service->servicePrice();

            if (is_numeric($servicePrice)){
                $total+= $servicePrice;
            } else{
                $rangePrice = true;
                $total = "Hesaplanacak";
            }
        }
        if ($rangePrice){
            return $total;
        }
        return $total;
    }

    function totalServiceAndProduct()
    { // toplam ürün ve hizmet satışı
        if (is_numeric($this->calculateTotal())){
            return $this->calculateTotal() + $this->sales->sum('total');
        } else{
            return "Hesaplanacak";
        }
    }

    public function calculateCampaignDiscount()
    { //kampanya indirimi
        if (is_numeric($this->totalServiceAndProduct())){
            $total = (($this->totalServiceAndProduct() * $this->discount) / 100);
            return $total;
        }
        return "Hesaplanacak";

    }

    public function calculateCollectedTotal() //tahsil edilecek tutar
    {
        if (is_numeric($this->totalServiceAndProduct()) && is_numeric($this->calculateCampaignDiscount())){
            $total = $this->totalServiceAndProduct() - $this->calculateCampaignDiscount() - $this->point;
            return $total;
        }
        return "Hesaplanacak";
    }

    public function remainingTotal() //kalan  tutar
    {
        return ($this->calculateCollectedTotal() - $this->payments->sum("price")) - $this->receivables()->whereStatus(1)->sum('price');
    }

    public function scheduleReminder()
    {
        // Randevu başlangıç saatinden hatırlatma zamanını hesaplayın (120 dakika önce)
        $reminderTime = $this->start_time->subMinutes($this->business->reminder_time);

        // Job'u dispatch et ve job ID'sini alın
        $job = new SendReminderJob($this);
        $jobId = app('queue')->later($reminderTime, $job);

        // Job ID'sini randevu kaydına kaydedin
        $this->job_id = $jobId;
        $this->save();
    }
    public function commentReminder()
    {
        // Randevu bitiş saati
        $endTime = $this->end_time; // 2024-11-11 21:00:00
        // 120 dakika öncesini belirleyin
        $reminderTime = $endTime->copy()->addMinutes(60);

        // İş için belirlenen mutlak zamanı kullanarak job'u oluştur
        $job = new SendCommentMessageJob($this);

        // Belirli bir tarihte işin çalışması için `later` metodunu mutlak tarih ile kullanın
        $jobId = app('queue')->later($reminderTime, $job);

        // Job ID'sini randevu kaydına kaydedin
        $this->job_comment_id = $jobId;
        $this->save();
    }

}
