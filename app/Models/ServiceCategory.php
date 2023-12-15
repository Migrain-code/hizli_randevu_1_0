<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceCategory extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable=['type_id', 'name'];
    protected $translatable = ['name', 'slug'];
    public function getName()
    {
        return $this->translate('name');
    }
    public function getSlug()
    {
        return $this->translate('slug');
    }
    public function subCategories()
    {
        return $this->hasMany(ServiceSubCategory::class,'category_id', 'id');
    }

    public function businessService()
    {
        return $this->hasMany(BusinessService::class, 'category', 'id');
    }
    public function type()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'type_id');
    }
}
