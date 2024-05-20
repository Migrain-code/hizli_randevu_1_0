<?php

namespace App\Http\Controllers\Api\PackageSale;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageSale\PackageSaleDetailResource;
use App\Http\Resources\PackageSale\PackageSaleListResource;
use App\Http\Resources\ProductSale\ProductSaleListResource;
use App\Models\PackageSale;
use Illuminate\Http\Request;

/**
 * @group Paket Satışları
 *
 */
class PackageSaleController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->customer = auth('api')->user();
            return $next($request);
        });
    }

    /**
     * Paket Satış Listesi
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(PackageSaleListResource::collection($this->customer->packets));
    }

    /**
     * Paket Detayı
     * <b>İstatistik alanı için başlıklara göre bilgiler aşağıda verilmiştir</b>
     * <ul>
     *     <li>Hakkınız var : summary.totalAmount</li>
     *     <li>Toplam Ödenecek : summary.totalPay</li>
     *     <li>Paket Kullandınız : summary.usageAmount</li>
     *     <li>Paket Ödemesi Yaptınız : summary.payedTotal</li>
     *     <li>Kalan Kullanım Hakkınız : summary.remainingAmount</li>
     *     <li>Kalan Ödemeniz : summary.remainingPayed</li>
     * </ul>
     */
    public function show(PackageSale $packageSale)
    {
        return response()->json(PackageSaleDetailResource::make($packageSale));
    }
}
