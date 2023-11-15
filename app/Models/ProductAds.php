<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductAds extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['name', 'price'];

    public function getName()
    {
        return $this->translate('name');
    }

    public function getPrice()
    {
        return $this->translate('price');
    }
}
