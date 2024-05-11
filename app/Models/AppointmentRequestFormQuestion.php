<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentRequestFormQuestion extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->hasMany(AppointmentRequestFormQuestionService::class, 'appointment_request_form_question_id', 'id');
    }

    public function question()
    {
        return $this->hasOne(RequestQuestion::class, 'id', 'question_id');
    }
}
