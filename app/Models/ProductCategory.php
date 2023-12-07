<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductCategory extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(ProductAds::class, 'category_id', 'id')->where('status', 1);
    }

    public function getName()
    {
        return $this->translate('name');
    }

    public function getSlug()
    {
        return $this->translate('slug');
    }
}
