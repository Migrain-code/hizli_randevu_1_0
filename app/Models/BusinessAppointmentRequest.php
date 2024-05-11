<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessAppointmentRequest extends Model
{
    use HasFactory;
    protected $casts = [
        "added_services" => "object",
        "questions" => "object"
    ];
}
