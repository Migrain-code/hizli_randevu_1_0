<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Ads;
use App\Models\Blog;
use App\Models\Business;
use App\Models\CustomerContact;
use App\Models\CustomerFaq;
use App\Models\CustomerFaqCategory;
use App\Models\DayList;
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
        $ads = Ads::where('type', 0)->get(); //Anasayfa reklamları
        $featuredServices = ServiceSubCategory::whereNotNull('order_number')->orderBy('order_number', 'asc')->get();//öne çıkan hizmetler
        $featuredCategories = FeaturedCategorie::where('status', 1)->get();
        $blogs = Blog::where('status', 1)->latest()->take(9)->get();
        $activities = Activity::where('status', 1)->latest()->take(4)->get();
        $mainPages = MaingPage::where('type', 0)->where('status', 1)->get();
        return view('welcome', compact('ads', 'featuredServices', 'featuredCategories', 'blogs', 'activities', 'mainPages'));
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
            $womanServices = $business->services()->where('type', 1)->get();
            $manServices = $business->services()->where('type', 2)->get();
            $unisexServices = $business->services()->where('type', 3)->get();
            $womanServiceCategories = $womanServices->groupBy('category');
            $manServiceCategories = $manServices->groupBy('category');
            $unisexServiceCategories = $unisexServices->groupBy('category');
            $manCategories = [];
            $womanCategories = [];
            foreach ($manServiceCategories as $key => $value) {
                $manCategories[] = ServiceCategory::find($key);
            }
            foreach ($womanServiceCategories as $key => $value) {
                $womanCategories[] = ServiceCategory::find($key);
            }

            return view('business.detail', compact('business', 'dayList', 'manServices', 'womanServiceCategories', 'manCategories', 'womanCategories', 'manServiceCategories', 'unisexServices', 'unisexServiceCategories'));

        }
        else{
            return to_route('main')->with('response', [
                'status' => "warning",
                'message' => "İşletme Kaydı Bulunamadı"
            ]);
        }
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
