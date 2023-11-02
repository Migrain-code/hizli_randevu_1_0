<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackagePropartie extends Model
{
    use HasFactory;
    public function propartie()
    {
        return $this->hasOne(Propartie::class,'id', 'propartie_id');
    }
}
