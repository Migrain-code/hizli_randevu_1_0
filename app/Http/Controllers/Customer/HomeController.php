<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Appointment;
use App\Models\Business;
use App\Models\BusinessComment;
use App\Models\Campaign;
use App\Models\CustomerFavorite;
use App\Models\CustomerNotificationMobile;
use App\Models\District;
use App\Models\PackageSale;
use App\Models\Page;
use App\Models\ProductAds;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {

        $customer = auth('customer')->user();
        $appointments = $customer->appointments()->latest()->take(4)->get();
        $sum_total = 0;/*total system payout*/
        $appointmentTotal = 0;/*appointment payment*/
        $appointmentTotals = [];
        foreach ($appointments as $appointment) {
                $total = 0;
                foreach ($appointment->services as $service) {
                    $total += $service->service->price;
                }
                $appointmentTotal += $total;
                $appointmentTotals[] = $total;
        }
        $sum_total += $appointmentTotal;
        $orderTotal = $customer->orders->sum('total');/*product sale payments*/
        $sum_total += $orderTotal;
        $packetPayment = $customer->packets->sum('total');
        $sum_total += $packetPayment;
        $payments = ['appointment' => $appointmentTotal, 'total' => $sum_total, 'orderTotal' => $orderTotal, 'packetPayment' => $packetPayment];

        $topAds = Ads::where('type', 1)->whereStatus(1)->get();
        $bottomAds = Ads::where('type', 2)->whereStatus(1)->get();
        $footerAds = Ads::where('type', 3)->whereStatus(1)->get();
        $productCategories = ProductCategory::where('status', 1)->has('products')->get();

        return view('customer.home.index', compact('customer', 'appointments', 'appointmentTotals', 'payments', 'topAds', 'bottomAds', 'productCategories', 'footerAds'));
    }

    public function appointments()
    {
        $customer = auth('customer')->user();

        return view('customer.appointment.index', compact('customer'));
    }

    public function appointmentDetail($id)
    {
        $appointment = Appointment::find($id);
        $terms = Page::whereId(6)->first();
        if ($appointment) {
            return view('customer.appointment.detail', compact('appointment', 'terms'));
        } else{
            return to_route('customer.appointment.index')->with('response', [
               'status' => "warning",
               'message' => "Randevu Bulunamadı"
            ]);
        }
    }

    public function addComment(Request $request)
    {
        $request->validate([
            'rating' => "required|min:1",
            'content' => "required",
            'terms' => "accepted",
        ], [], [
            'rating' => "Puan",
            'content' => "Yorum Metni",
            'terms' => "Şartlar ve Koşullar"
        ]);
        $appointment = Appointment::find($request->input('appointment_id'));
        if($appointment->status == 6 or $appointment->status == 5){
            if($appointment->comment_status == 0){
                $businessComment = new BusinessComment();
                $businessComment->business_id = $request->input('business_id');
                $businessComment->appointment_id = $request->input('appointment_id');
                $businessComment->customer_id = auth('customer')->id();
                $businessComment->point = $request->input('rating');
                $businessComment->content = $request->input('content');
                if ($businessComment->save()) {
                    Appointment::find($request->input('appointment_id'))->update([
                        'comment_status' => 1,
                    ]);
                    return back()->with('response', [
                        'status' => "success",
                        'message' => "Yorumunuz Başarılı Bir Şekilde İletildi"
                    ]);
                }
            } else{
                return back()->with('response', [
                    'status' => "warning",
                    'message' => "Bu randevuya yorum gönderdiniz başka yorum gönderemezsiniz."
                ]);
            }
        } else{
            return back()->with('response', [
                'status' => "warning",
                'message' => "Bu randevuya yorum yapabilmek için randevunun tamamlanmasını beklemeniz gerekmektedir."
            ]);
        }


    }

    public function packets()
    {
        $customer = auth('customer')->user();
        $packets = $customer->packets()->paginate(setting('speed_pagination_number'));
        $packageTypes = [
            'Seans',
            'Dakika'
        ];
        return view('customer.packet.index', compact('packets', 'packageTypes'));
    }

    public function campaigns()
    {
        /*$product = new Campaign();
        $product->discount = 1;
        $product->code = 0;
        $product->start_time= "2023-11-06 21:22:36.000000";
        $product->end_date= "2023-11-06 23:22:36.000000";
        $product->image = "youtube.com";
        $product->business_id = 8;
        $product
            ->setTranslation('title', 'en', 'Product Name in English')
            ->setTranslation('title', 'de', 'Produktname auf Deutsch')
            ->setTranslation('title', 'tr', 'Ürün Adı Türkçe')
            ->setTranslation('title', 'fr', 'Nom du produit en français')
            ->setTranslation('title', 'it', 'Nome del prodotto in italiano')
            ->setTranslation('description', 'en', 'Product Name in en')
            ->setTranslation('description', 'de', 'Product Name in de')
            ->setTranslation('description', 'tr', 'Product Name in tr')
            ->setTranslation('description', 'fr', 'Product Name in fr')
            ->setTranslation('description', 'it', 'Product Name in it')
            ->setTranslation('slug', 'en', Str::slug('Product Name in en'))
            ->setTranslation('slug', 'de', Str::slug('Product Name in de'))
            ->setTranslation('slug', 'tr', Str::slug('Product Name in tr'))
            ->setTranslation('slug', 'fr', Str::slug('Product Name in fr'))
            ->setTranslation('slug', 'it', Str::slug('Product Name in it'))
            ->save();*/
        $customer = auth('customer')->user();
        $campaigns = $customer->campaigns()->paginate(setting('speed_pagination_number'));
        //dd($campaigns);
        return view('customer.campaign.index', compact('campaigns'));
    }

    public function campaignDetail($slug)
    {
        $campaign = Campaign::whereJsonContains('slug', [App::getLocale() => $slug])
            ->first();

        return view('customer.campaign.detail', compact('campaign'));
    }
    public function packetDetail($id)
    {
        $packageTypes = [
            'Seans',
            'Dakika'
        ];
        $packet = PackageSale::find($id);
        if ($packet) {
            return view('customer.packet.detail', compact('packet', 'packageTypes'));
        }
        abort(404);
    }

    public function orders()
    {
        $customer = auth('customer')->user();
        $paymentTypes = [
            'Nakit Ödeme',
            'Banka/Kredi Kartı',
            'EFT/Havale',
            'Diğer',
        ];
        $orders = $customer->orders()->paginate(setting('speed_pagination_number'));

        return view('customer.order.index', compact('customer', 'orders', 'paymentTypes'));
    }

    public function favorites()
    {
        $customer = auth('customer')->user();
        $favorites =$customer->favorites()->pluck('business_id');
        $businesses = Business::whereIn('id', $favorites)->get();

        return view('customer.favorite.index', compact('customer', 'businesses'));
    }

    public function comments()
    {
        $customer = auth('customer')->user();
        $businessComments = $customer->comments()->latest()->paginate(setting('speed_pagination_number'));

        return view('customer.comment.index', compact('businessComments'));
    }

    /*public function addicted()
    {
        $customer = auth('customer')->user();
        $appointments = Appointment::where('customer_id', $customer->id)
            ->groupBy('business_id')
            ->select('business_id', DB::raw('count(*) as count_appointments'))
            ->orderBy('count_appointments', 'desc')
            ->get();
        $businesses = [];
        foreach ($appointments as $appointment) {
            $businesses[] = Business::find($appointment->business_id);
        }

        return view('customer.addicted.index', compact('customer', 'businesses'));
    }*/

    public function getDistrict(Request $request)
    {
        $districts = District::where('city_id', $request->city_id)->get();
        return $districts;
    }

    public function cancelAppointment(Request $request)
    {
        $appointment = Appointment::find($request->id);
        $appointment->status = 3;
        $appointment->save();
        foreach ($appointment->services as $service){
            $service->status = 3;
            $service->save();
        }
        $message = $appointment->business->name . ' İşletmesine ' . $appointment->start_time->format('d.m.Y H:i') . ' tarihindeki randevunuz iptal edildi.';
        $appointment->customer->sendSms($message);
        $appointment->customer->sendNotification('Randevunuz Sizin Tarafınızdan İptal Edildi', $message);
        return response()->json([
            'status' => "success",
            'message' => $appointment->start_time->format('d.m.Y H:i') . " Tarihindeki Randevunuz Başarılı Bir Şekilde İptal Edildi",
        ]);
    }

    public function addFavorite(Request $request)
    {
        $existBusiness = CustomerFavorite::where('customer_id', auth('customer')->id())
            ->where('business_id', $request->id)
            ->first();
        if ($existBusiness) {
            $existBusiness->delete();
            return response()->json([
                'status' => "info",
                'message' => "İşletme Favorilerinizden Çıkarıldı",
                'type' => "delete"
            ]);
        } else {
            $favorite = new CustomerFavorite();
            $favorite->customer_id = auth('customer')->id();
            $favorite->business_id = $request->id;
            $favorite->save();
            return response()->json([
                'status' => "success",
                'message' => "İşletme Favorilerinize Eklendi",
                'type' => "add"
            ]);
        }

    }

    public function removeFavorite(Request $request)
    {
        $favorite = CustomerFavorite::find($request->id);
        if ($favorite->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "İşletme Favorilerinizden Çıkarıldı",
            ]);
        }
    }

    public function notifications()
    {
        return view('customer.notification.index');
    }

    public function notificationDetail($slug)
    {
        $notification = CustomerNotificationMobile::where('slug', $slug)->first();
        $notification->status = 1;
        $notification->save();

        return view('customer.notification.detail', compact('notification'));
    }


    public function permissions()
    {
        return view('customer.permission.index');
    }

    public function updatePermission(Request $request)
    {
        $notification = auth()->user()->permissions;

        if ($request->input('name') == "is_notification"){
            $notification->is_notification = boolval($request->checked);
            $notification->save();
        }
        elseif($request->input('name') == "is_phone"){
            $notification->is_phone = boolval($request->checked);
            $notification->save();
        }
        elseif ($request->input('name') == "is_email"){
            $notification->is_email = boolval($request->checked);
            $notification->save();
        }
        elseif ($request->input('name') == "is_sms"){
            $notification->is_sms = boolval($request->checked);
            $notification->save();
        }
        else{
            return response()->json([
                'status' => "warning",
                'message' => "Hata Bildirim Ayarlarınız Güncellenemedi"
            ]);
        }
        return response()->json([
            'status' => "success",
            'message' => "Bildirim Ayarlarınız Güncellendi"
        ]);

    }
}

