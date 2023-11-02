<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessService;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function service($slug)
    {
        $subCategory = ServiceSubCategory::where('slug', $slug)->firstOrFail();/*hizmet kategorisini bul*/
        $businessIds = BusinessService::where('sub_category', $subCategory->id)->pluck('business_id');
        $businesses = Business::whereIn('id', $businessIds)->latest('order_number')->get();

        return view('search.service', compact('businesses'));
    }
}
