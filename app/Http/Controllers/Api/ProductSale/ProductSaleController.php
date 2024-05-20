<?php

namespace App\Http\Controllers\Api\ProductSale;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductSale\ProductSaleListResource;
use Illuminate\Http\Request;

/**
 * @group Siparişlerim
 */
class ProductSaleController extends Controller
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
     * Sipariş Listesi
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = $this->customer->orders;
        return response()->json(ProductSaleListResource::collection($orders));
    }
}
