<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestQuestion extends Model
{
    use HasFactory;

    public function answers()
    {
        return $this->hasMany(RequestQuestionAnswer::class, 'question_id', 'id');
    }
}
