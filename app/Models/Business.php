<?php

namespace App\Models;

use App\Models\Admin\BussinessPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;


class Business extends Authenticatable
{
    use HasFactory;

    protected $guarded = ['business'];
    protected $casts = [
        'slider' => 'object',
    ];

    const STATUS_LIST=[
        0 =>[
            'text'=>"Kurulum Tamamlanmadı",
        ],
        1=>[
            'text'=>"Engellendi",
        ],
        2=>[
            'text'=>"Aktif"
        ]
    ];

    public function status($type)
    {
        return self::STATUS_LIST[$this->status][$type];
    }
    public function package()
    {
        return $this->hasOne(BussinessPackage::class, 'id', 'package_id');
    }

    public function category()
    {
        return $this->hasOne(BusinessCategory::class, 'id', 'category_id');
    }
    public function type()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'type_id');
    }

    public function workTimes()
    {
        return $this->hasMany(BusinessWorkTime::class, 'business_id', 'id')->orderBy('que');
    }

    public function services()
    {
        return $this->allServices()->where('is_delete', 0);
    }

    public function singleService($id)
    {
        return $this->services()->where('sub_category', $id)->get();
    }
    public function allServices()
    {
        return $this->hasMany(BusinessService::class, 'business_id', 'id');
    }
    public function personel()
    {
        return $this->hasMany(Personel::class, 'business_id', 'id')->orderBy('order_number', 'asc');
    }

    public function sliders()
    {
        return $this->hasMany(BusinessSlider::class, 'business_id', 'id');
    }

    public function service()
    {
        return $this->hasOne(BusinessService::class, 'business_id', 'id');
    }

    public function gallery()
    {
        return $this->hasMany(BusinessGallery::class, 'business_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(ProductSales::class, 'business_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'business_id', 'id');
    }

    public function packages()
    {
        return $this->hasMany(PackageSale::class, 'business_id', 'id');
    }
    public function range()
    {
        return $this->hasOne(AppointmentRange::class, 'id', 'appoinment_range');
    }
    public function customers()
    {
        return $this->hasMany(BusinessCustomer::class, 'business_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'business_id', 'id');
    }

    public function cities()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

    public function districts()
    {
        return $this->hasOne(District::class, 'id', 'district');

    }
    public function forms()
    {
        return $this->hasMany(AppointmentRequestForm::class, 'business_id', 'id');
    }
    public function activeForm()
    {
        return $this->forms()->where('is_default', 1)->first();
    }
    public function comments()
    {
        return $this->hasMany(BusinessComment::class, 'business_id', 'id')/*->where('status', 1)*/->latest();
    }
    public function officials()
    {
        return $this->hasMany(BusinessOfficial::class, 'company_id', 'company_id');
    }
    public function official()
    {
        return $this->hasOne(BusinessOfficial::class, 'business_id', 'id')->withDefault([
            'name' => "Yetkilisi Yok"
        ]);
    }

    public function checkFavorite($customerId)
    {
        return $this->hasMany(CustomerFavorite::class, 'business_id', 'id')->where('customer_id', $customerId)->exists();
    }
    public function points()
    {
        $businessComments = $this->comments;
        $point = $businessComments->sum("point");

        if ($point == 0 || $businessComments->count() == 0) {
            return 0;
        } else {
            $total = $point / $businessComments->count();
            return $total;
        }
    }
    public function rooms()
    {
        return $this->hasMany(BusinessRoom::class, 'business_id', 'id')->whereIsDelete(0);
    }

    public function activeRooms()
    {
        return $this->rooms()->whereStatus(1)->orderBy('is_main', 'desc');
    }
    public function scopeOrderByAppointmentCount($query)
    {
        return $query->leftJoin('appointments', 'businesses.id', '=', 'appointments.business_id')
            ->select('businesses.*')
            ->groupBy('businesses.id')
            ->orderByRaw('COUNT(appointments.id) DESC');
    }

    public function closeDays()
    {
        return $this->hasMany(BusinessCloseDate::class, 'business_id', 'id');
    }

    public function activeCloseDays()
    {
        return $this->closeDays()->where('status', 1);
    }

    public function isClosed($date)
    {
        $closeDate = Carbon::parse($date);
        $businessCloseDates = $this->activeCloseDays;

        $isClosed = $businessCloseDates->contains(function ($closeDateRecord) use ($closeDate) {
            $startTime = Carbon::parse($closeDateRecord->start_time);
            $endTime = Carbon::parse($closeDateRecord->end_time);

            return $closeDate->between($startTime, $endTime);
        });

        return $isClosed;
    }
}
