<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    use HasFactory;

    public function proparties()
    {
        return $this->hasMany(ServicePackagePropartie::class,'package_id', 'id');
    }
}
