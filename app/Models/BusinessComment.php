<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessComment extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id')->withDefault([
            'id' => "Kullanıcı",
            'name' => "Kullanıcı"
        ]);
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');

    }
}
