<?php

namespace App\Models;

use App\Models\Admin\BussinessPackagePropartie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BussinessPackagePropartieList extends Model
{
    use HasFactory;

    public function packages()
    {
        return $this->hasMany(BussinessPackagePropartie::class, 'propartie_id', 'id');
    }
}
