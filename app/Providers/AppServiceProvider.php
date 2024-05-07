<?php

namespace App\Providers;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessInfo;
use App\Models\City;
use App\Models\FeaturedCategorie;
use App\Models\ForBusiness;
use App\Models\MaingPage;
use App\Models\Page;
use App\Models\RecommendedLink;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        $settings = [];
        foreach (Setting::all() as $item) {
            $settings[$item->name] = $item->value;
        }
        \Config::set('settings', $settings);

        $sections = [];
        foreach (ForBusiness::all() as $item) {
            $sections[$item->name] = $item->value;
        }
        \Config::set('sections', $sections);

        $main_pages = [];
        foreach (MaingPage::all() as $item) {
            $main_pages[$item->name] = $item->value;
        }
        \Config::set('main_pages', $main_pages);

        \View::share('use_pages', Page::whereIn('id', [5, 6, 7])->get());

        $cities = City::orderBy('name')->get();
        View::share('cities', $cities);

        $services =  ServiceCategory::orderBy('order_number', 'asc')->take(10)->get();
        View::share('services', $services);

        $categories = BusinessCategory::where('is_menu', 1)->get();
        View::share('categories', $categories);

        $featuredCategory = ServiceCategory::where('is_menu', 1)->orderBy('order_number', 'asc')->take(6)->get();
        View::share('featuredCategory', $featuredCategory);

        $recommendedLinks = RecommendedLink::select('title', 'url')->get();
        View::share('recommendedLinks', $recommendedLinks);

        Paginator::useBootstrapFour();
    }
}
