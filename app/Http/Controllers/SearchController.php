<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessService;
use App\Models\City;
use App\Models\District;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SearchController extends Controller
{
    public function service($slug)
    {
        $subCategory = ServiceSubCategory::whereJsonContains('slug->' . App::getLocale(), $slug)->firstOrFail();/*hizmet kategorisini bul*/
        $businessIds = BusinessService::where('sub_category', $subCategory->id)->pluck('business_id');
        $businesses = Business::whereIn('id', $businessIds)->latest('order_number')->paginate(12);

        return view('search.service', compact('businesses', 'subCategory'));
    }

    public function cityAndCategory($city, $category)
    {
        $category = BusinessCategory::whereJsonContains('slug->' . App::getLocale(), $category)->first();
        $city = City::where('slug', $city)->first();
        $businesses = Business::where('city', $city)->where('category_id', $category)->latest('order_number')->paginate(12);
        return view('search.service', compact('businesses'));
    }

    public function cityAndServiceCategory(Request $request)
    {
        if ($request->filled('city_id') && $request->filled('service_id')){
            $city = City::find($request->input('city_id'));
            $category = ServiceCategory::find($request->input('service_id'));
            $cityDistrict = explode('-', $request->city_id);
            if (count($cityDistrict) == 2){
                $district = District::find($cityDistrict[1]);
                return to_route('search.serviceCityAndDistrictCategorySearch', [$city->slug,$district->slug, $category->getSlug()]);
            }
            return to_route('search.serviceCityAndCategorySearch', [$city->slug, $category->getSlug()]);
        }
        else if ($request->filled('city_id')){
            $city = City::find($request->input('city_id'));
            return to_route('search.citySearch', $city->slug);
        }
        else if ($request->filled('service_id')){
            $category = ServiceCategory::find($request->input('service_id'));
            return to_route('search.serviceCategorySearch', $category->getSlug());
        }
        else{
            return back()->with('response', [
               'status' => "info",
               'message' => "Bir hizmet veya şehir seçmeden arama yapamazsınız"
            ]);
        }
    }

    public function citySearch($slug)
    {
        $city = City::where('slug', $slug)->first();
        $businesses = Business::where('city', $city->id)->paginate(12);
        return view('search.service', compact('businesses'));
    }

    public function serviceCategorySearch($slug)
    {
        $category = ServiceCategory::whereJsonContains('slug->' . App::getLocale(), $slug)->first();
        $businesses = Business::query()
            ->whereHas('services', function ($query) use ($category) {
                $query->where('category', $category->id);
            })
            ->paginate(12);
        return view('search.service', compact('businesses', 'category'));
    }

    public function serviceCityAndCategorySearch($city, $slug)
    {
        $city = City::where('slug', $city)->first();
        $category = ServiceCategory::whereJsonContains('slug->' . App::getLocale(), $slug)->first();

        $businesses = Business::query()
            ->where('city', $city->id)
            ->whereHas('services', function ($query) use ($category) {
                $query->where('category', $category->id);
            })
            ->paginate(12);

        return view('search.service', compact('businesses', 'city', 'category'));
    }
    public function serviceCityAndDistrictCategorySearch($city,$districtSlug, $slug)
    {

        $city = City::where('slug', $city)->first();
        $district = District::where('slug', $districtSlug)->first();
        $category = ServiceCategory::whereJsonContains('slug->' . App::getLocale(), $slug)->first();

        $businesses = Business::query()
            ->where('city', $city->id)
            ->where('district', $district->id)
            ->whereHas('services', function ($query) use ($category) {
                $query->where('category', $category->id);
            })
            ->paginate(12);

        return view('search.service', compact('businesses', 'district', 'category'));
    }
    public function businessCategoryAndCity(Request $request)
    {
        if ($request->filled('city_id') && $request->filled('category_id')){
            $city = City::find($request->input('city_id'));
            $category = BusinessCategory::find($request->input('category_id'));
            $cityDistrict = explode('-', $request->city_id);
            if (count($cityDistrict) == 2){
                $district = District::find($cityDistrict[1]);
                return to_route('search.businessCategoryAndCityAndDistrictSearch', [$city->slug,$district->slug, $category->getSlug()]);
            }
            return to_route('search.businessCategoryAndCitySearch', [$city->slug, $category->getSlug()]);
        }
        else if ($request->filled('city_id')){
            $city = City::find($request->input('city_id'));
            return to_route('search.citySearch', $city->slug);
        }
        else if ($request->filled('category_id')){
            $category = BusinessCategory::find($request->input('category_id'));
            return to_route('search.businessCategorySearch', $category->getSlug());
        }
        else{
            return back()->with('response', [
                'status' => "info",
                'message' => "Bir işletme türü veya şehir seçmeden arama yapamazsınız"
            ]);
        }
    }

    public function businessCategorySearch($category)
    {

        $category = BusinessCategory::whereJsonContains('slug->' . App::getLocale(), $category)->first();
        $businesses = Business::where('category_id', $category->id)->paginate(12);
        return view('search.service', compact('businesses', 'category'));
    }

    public function businessCategoryAndCitySearch($city, $category)
    {
        $category = BusinessCategory::whereJsonContains('slug->' . App::getLocale(), $category)->first();
        $city = City::where('slug', $city)->first();

        $businesses = Business::where('city', $city->id)
            ->where('category_id', $category->id)
            ->paginate(12);

        return view('search.service', compact('businesses', 'city', 'category'));
    }

    public function businessCategoryAndCityAndDistrictSearch($city,$districtSlug, $category)
    {
        $category = BusinessCategory::whereJsonContains('slug->' . App::getLocale(), $category)->first();
        $city = City::where('slug', $city)->first();
        $district = District::where('slug', $districtSlug)->first();

        $businesses = Business::where('city', $city->id)
            ->where('district', $district->id)
            ->where('category_id', $category->id)
            ->paginate(12);

        return view('search.service', compact('businesses', 'district', 'category'));
    }

    public function salonName(Request $request)
    {
        $businesses = Business::select('id', 'name')->where('name', 'like', '%' . $request->q . '%')
            ->take(50)
            ->get();

        return response()->json([
            'businesses' => $businesses,
        ]);
    }
}
