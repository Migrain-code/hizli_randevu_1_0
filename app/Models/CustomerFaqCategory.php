<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CustomerFaqCategory extends Model
{
    use HasFactory, HasTranslations;
    protected $translatable = ['name', 'slug'];
    public function faqs()
    {
        return $this->hasMany(CustomerFaq::class, 'category_id', 'id');
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
