<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentRequestFormServiceResource;
use App\Models\Activity;
use App\Models\Ads;
use App\Models\AppointmentRequestFormQuestion;
use App\Models\AppointmentRequestFormService;
use App\Models\Blog;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessService;
use App\Models\City;
use App\Models\CustomerContact;
use App\Models\CustomerFaq;
use App\Models\CustomerFaqCategory;
use App\Models\DayList;
use App\Models\District;
use App\Models\FeaturedCategorie;
use App\Models\MaingPage;
use App\Models\Page;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $brandList = Ads::where('type', 8)->get(); //Anasayfa marka reklamları
        $ads = Ads::where('type', 0)->get(); //Anasayfa reklamları
        $featuredServices = ServiceSubCategory::where('is_featured', 1)->orderBy('order_number', 'asc')->get();//öne çıkan hizmetler
        $featuredCategories = BusinessCategory::where('is_featured', 1)->where('status', 1)->take(6)->get();

        $blogs = Blog::where('status', 1)->latest()->take(9)->get();
        $activities = Activity::where('status', 1)->latest()->take(3)->get();
        $mainPages = MaingPage::where('type', 0)->where('status', 1)->get();
        return view('welcome', compact('brandList','ads', 'featuredServices', 'featuredCategories', 'blogs', 'activities', 'mainPages'));
    }

    public function businessId($id)
    {
        $business = Business::find($id);
        return to_route('business.detail', $business->slug);
    }
    public function businessDetail($slug)
    {
        $business = Business::where('slug', $slug)
            ->first();
        if ($business){

            $dayList = DayList::all();

            $womanServicesArray = $business->services()->where('type', 1)->with('categorys')->get();
            $womanServiceCategories = $womanServicesArray->groupBy('categorys.name');
            $womanServices = $this->transformServices($womanServiceCategories);

            $manServicesArray = $business->services()->where('type', 2)->with('categorys')->get();
            $manServiceCategories = $manServicesArray->groupBy('categorys.name');
            $manServices = $this->transformServices($manServiceCategories);

            $unisexServicesArray = $business->services()->where('type', 3)->with('categorys')->get();
            $unisexServiceCategories = $unisexServicesArray->groupBy('categorys.name');
            $unisexServices = $this->transformServices($unisexServiceCategories);

            return view('business.detail', compact('business', 'dayList', 'womanServices', 'manServices', 'unisexServices'));

        }
        else{
            return to_route('main')->with('response', [
                'status' => "warning",
                'message' => "İşletme Kaydı Bulunamadı"
            ]);
        }
    }

    function transformServices($womanServiceCategories)
    {
        $transformedDataWoman = [];
        $transformedFeaturedServices = [];
        foreach ($womanServiceCategories as $category => $services) {
            $transformedServices = [];
            foreach ($services as $service) {
                //if ($service->personels->count() > 0) { //hizmeti veren personel sayısı birden fazla ise listede göster
                $transformedServices[] = [
                    'id' => $service->id,
                    'name' => $service->subCategory->getName(),
                    'price' => $service->price,
                ];
                if ($service->is_featured == 1){
                    $transformedFeaturedServices[] = [
                        'id' => $service->id,
                        'name' => $service->subCategory->getName(),
                        'price' => $service->price,
                    ];
                }

            }
            $transformedDataWoman[] = [
                'id' => $services->first()->category,
                'name' => $category,
                'services' => $transformedServices,
                'featuredServices' => $transformedFeaturedServices
            ];
        }
        return [
            'services' => $transformedDataWoman,
            'featured' => $transformedFeaturedServices
        ];
    }

    public function about()
    {
        $page = Page::find(3);
        return view('page', compact('page'));
    }

    public function support()
    {
        return view('support');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactAdd(Request $request)
    {
        $request->validate([
            'name' => "required",
            'surname' => "required",
            'email' => "required|min:3|email",
            'phone' => "required|min:3",
            'subject' => "required|min:3",
            'content' => "required|min:3",
        ], [], [
            'name' => "Ad",
            'surname' => "Soyad",
            'email' => "E-posta",
            'phone' => "Telefon",
            'subject' => "Konu",
            'content' => "İçerik",
        ]);
        $contactSearch = CustomerContact::where('ip_address', $request->ip())->latest()->first();
        if ($contactSearch->created_at < Carbon::now()->subMinutes(5)){
            $contact = new CustomerContact();
            $contact->name =  $request->input('name');
            $contact->surname = $request->input('surname');
            $contact->email =  $request->input('email');
            $contact->phone =  $request->input('phone');
            $contact->subject =  $request->input('subject');
            $contact->content =  $request->input('content');
            $contact->ip_address = $request->ip();
            $contact->save();

            return to_route('contact')->with('response', [
                'status' => "success",
                'message' => "İletişim Mesajı Gönderildi"
            ]);
        } else{
            return to_route('contact')->with('response', [
                'status' => "warning",
                'message' => "Yeni Bir İletişim Mesajı Göndermeden Önce 5 Dk beklemelisiniz"
            ]);
        }


    }
    public function faq()
    {
        $categories = CustomerFaqCategory::where('status', 1)->latest('order_number')->get();
        return view('sss', compact('categories'));
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->first();
        return view('page', compact('page'));
    }
}
