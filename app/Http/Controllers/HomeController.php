<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Ads;
use App\Models\Blog;
use App\Models\Business;
use App\Models\DayList;
use App\Models\FeaturedCategorie;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $ads = Ads::where('type', 0)->get(); //Anasayfa reklamları
        $featuredServices = ServiceSubCategory::where('featured', '>', 0)->orderBy('featured', 'asc')->get();//öne çıkan hizmetler
        $featuredCategories = FeaturedCategorie::where('status', 1)->get();
        $blogs = Blog::where('status', 1)->latest()->take(9)->get();
        $activities = Activity::where('status', 1)->latest()->take(4)->get();
        return view('welcome', compact('ads', 'featuredServices', 'featuredCategories', 'blogs', 'activities'));
    }

    public function businessDetail($slug)
    {
        $business = Business::where('slug', $slug)->first();
        $dayList = DayList::all();
        $womanServices = $business->services()->where('type', 1)->get();
        $manServices = $business->services()->where('type', 2)->get();
        $womanServiceCategories = $womanServices->groupBy('category');
        $manServiceCategories = $manServices->groupBy('category');
        $manCategories = [];
        $womanCategories = [];
        foreach ($manServiceCategories as $key => $value) {
            $manCategories[] = ServiceCategory::find($key);
        }
        foreach ($womanServiceCategories as $key => $value) {
            $womanCategories[] = ServiceCategory::find($key);
        }

        return view('business.detail', compact('business', 'dayList', 'manServices', 'womanServiceCategories', 'manCategories', 'womanCategories', 'manServiceCategories'));
    }

}
