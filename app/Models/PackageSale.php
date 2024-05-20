<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageSale extends Model
{
    use HasFactory;
    protected $casts=["seller_date" => "datetime"];
    const PACKAGE_TYPES = [
        0 => ["id" => 0, "name" => "Seans"],
        1 => ["id" => 1, "name" => "Dakika"],
    ];
    public function packageType($type)
    {
        return self::PACKAGE_TYPES[$this->type][$type] ?? null;
    }
    public function customer()
    {
        return $this->hasOne(Customer::class,'id', 'customer_id');
    }
    public function personel()
    {
        return $this->hasOne(Personel::class,'id', 'personel_id');
    }

    public function business()
    {
        return $this->hasOne(Business::class,'id', 'business_id');
    }
    public function service()
    {
        return $this->hasOne(BusinessService::class,'id', 'service_id');
    }

    public function usages()
    {
        return $this->hasMany(PackageUsage::class, 'package_id', 'id');
    }
    public function payments()
    {
        return $this->hasMany(PackagePayment::class, 'package_id', 'id');
    }
}
