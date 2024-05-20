<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentServices extends Model
{
    use HasFactory;

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function service()
    {
        return $this->hasOne(BusinessService::class, 'id', 'service_id');
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
