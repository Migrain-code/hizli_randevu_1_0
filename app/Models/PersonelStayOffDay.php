<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonelStayOffDay extends Model
{
    use HasFactory;

    protected $casts = ["start_time" => "datetime", 'end_time' => "datetime"];

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
