<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MaingPage extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['name', 'value', 'button_text'];

    public function getName()
    {
        return $this->translate('name');
    }

    public function getValue()
    {
        return $this->translate('value');
    }

    public function getButtonText()
    {
        return $this->translate('button_text');
    }
}
