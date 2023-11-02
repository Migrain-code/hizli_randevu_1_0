<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSubCategory extends Model
{
    use HasFactory;
    public function businessService()
    {
        return $this->hasMany(BusinessService::class, 'sub_category', 'id');
    }
    public function category()
    {
        return $this->hasOne(ServiceCategory::class,'id', 'category_id');
    }
}
