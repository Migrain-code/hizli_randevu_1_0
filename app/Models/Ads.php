<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Ads extends Model
{
    use HasFactory, HasTranslations;
    protected $translatable = ['title', 'description'];
    const TYPE_LIST = [
        0 => [
            'name' => "anasayfa_reklamları",
        ],
        1 => [
            'name' => "müşteri ana sayfası üst reklamları",
        ],
        2 => [
            'name' => "müşteri ana sayfası randevu alt reklamları",
        ],
        3 => [
            'name' => "müşteri ana sayfası footer reklamları"
        ],
        4 => [
            'name' => "blog reklamları"
        ],
        5 => [
            'name' => "etkinlik reklamları"
        ],
    ];

    public function type()
    {
        return self::TYPE_LIST[$this->type];
    }

    public function getTitle()
    {
        return $this->translate('title');
    }

    public function getDescription()
    {
        return $this->translate('description');
    }
}
