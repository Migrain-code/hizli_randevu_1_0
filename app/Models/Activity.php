<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Activity extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable=['title', 'description'];
    protected $casts=['start_time' => 'datetime', 'end_time' => "datetime"];

    public function getTitle()
    {
        return $this->translate('title');
    }
    public function getDescription()
    {
        return $this->translate('description');
    }
    public function personels()
    {
        return $this->hasMany(ActivityBusiness::class, 'activity_id', 'id')->where('status', 1);
    }
    public function sponsors()
    {
        return $this->hasMany(ActivitySponsor::class, 'activity_id', 'id')->latest();
    }

    public function sliders()
    {
        return $this->hasMany(ActivitySlider::class, 'activity_id', 'id')->latest();
    }

    public function images()
    {
        return $this->hasMany(ActivityImages::class, 'activity_id', 'id')->latest();
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }
}
