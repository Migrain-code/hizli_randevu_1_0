<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function districts()
    {
        return $this->hasMany(District::class, 'city_id','id');
    }

    public function featuredDistricts()
    {
        return $this->districts()->where('is_featured', 1);
    }
}
