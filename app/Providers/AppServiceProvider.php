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
use Illuminate\Support\Facades\Request;
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
        $request = Request::instance();
        if (!$request->is('api/*')) {
            $settings = [];

            foreach (Setting::all() as $item) {
                $settings[$item->name] = $item->value;
            }
            $sections = [];
            foreach (ForBusiness::all() as $item) {
                $sections[$item->name] = $item->value;
            }
            $main_pages = [];
            foreach (MaingPage::all() as $item) {
                $main_pages[$item->name] = $item->value;
            }

            \Config::set('sections', $sections);
            \Config::set('settings', $settings);
            \Config::set('main_pages', $main_pages);
            $globalData = [
                'use_pages' => Page::whereIn('slug', ['gizlilik-kosullari', 'sartlar-ve-kosullar'])->get(),
                'pages' => Page::whereNotIn('slug', ['gizlilik-kosullari', 'sartlar-ve-kosullar'])->where('status', 1)->take('5')->get(),
                'infos' => BusinessInfo::where('status', 0)->get(),
            ];

            \View::share('globalData', $globalData);
            $cities = City::orderBy('name')->get();
            View::share('cities', $cities);

            $services = ServiceCategory::where('order_number', '<>', null)->orderBy('order_number', 'asc')->get();
            View::share('services', $services);
            $categories = BusinessCategory::all();
            View::share('categories', $categories);

            $featuredCategory = ServiceCategory::whereNotNull('order_number')->orderBy('order_number', 'asc')->take(6)->get();
            View::share('featuredCategory', $featuredCategory);

            $recommendedLinks = RecommendedLink::select('title', 'url')->get();
            View::share('recommendedLinks', $recommendedLinks);
        }
        Paginator::useBootstrapFour();
    }
}
