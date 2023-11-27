<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotificationMobile extends Model
{
    use HasFactory;

    public function icon()
    {
        return $this->hasOne(NotificationIcon::class, 'id' ,'notification_id');
    }
}
