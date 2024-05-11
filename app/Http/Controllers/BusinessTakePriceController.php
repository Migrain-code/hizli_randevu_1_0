<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentRequestFormServiceResource;
use App\Models\AppointmentRequestFormService;
use App\Models\Business;
use App\Models\BusinessAppointmentRequest;
use Illuminate\Http\Request;

class BusinessTakePriceController extends Controller
{
    public function businessTakePrice($slug)
    {
        $business = Business::where('slug', $slug)
            ->first();
        if ($business){
            $form = $business->activeForm();
            if (!$form){
                return to_route('business.detail', $business->slug)->with('response', [
                    'status' => "warning",
                    'message' => "İşletme Talep Alma Formunu Kapattı"
                ]);
            }
            $services = $form->services;
            return view('price.index', compact('business', 'form', 'services'));
        } else{
            return to_route('main')->with('response', [
                'status' => "warning",
                'message' => "İşletme Kaydı Bulunamadı"
            ]);
        }
    }

    public function takePriceQuestion(Request $request)
    {
        $findService = AppointmentRequestFormService::find($request->service_id);
        if ($findService){

            return AppointmentRequestFormServiceResource::make($findService);
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Seçtiğiniz hizmet artık bulunmamaktadır"
            ]);
        }
    }

    public function takePriceQuestionForm(Request $request, $slug)
    {
        $request->validate([
           'request_form_service_id' => "required",
           'goal_time' => 'required',
           'goal_time_type' => 'required',
           'user_name' => 'required',
           'phone' => 'required',
           'email' => 'required',
           'contact_type' => 'required'
        ], [], [
           'request_form_service_id' => "Hizmet seçim",
           'goal_time' => 'Zaman',
           'goal_time_type' => "Ne zaman",
           'user_name' => "Adınız Soyadınız",
           'phone' => "Telefon Numarası",
           'email' => 'E-posta Adresi',
           'contact_type' => 'İletişim Türü Seçimi'
        ]);
        $business = Business::where('slug', $slug)
            ->first();
        if (!isset($business)){
            return to_route('main')->with('response', [
                'status' => "warning",
                'message' => "Sistemsel Bir Hata Sebebi İle işletme bilgisi alınamadı"
            ]);
        }
        $form = $business->activeForm();
        if ($form){
            $findService = AppointmentRequestFormService::find($request->request_form_service_id);
        } else{
            return to_route('main')->with('response', [
                'status' => "warning",
                'message' => "Sistemsel Bir Hata Sebebi İle Hizmet bilgisi alınamadı"
            ]);
        }
        //$request->dd();
        $businessAppointmentRequest = new BusinessAppointmentRequest();
        $businessAppointmentRequest->business_id = $business->id;
        $businessAppointmentRequest->service_name = $findService->service->subCategory->getName();
        $businessAppointmentRequest->goal_time_type = $request->goal_time_type;
        $businessAppointmentRequest->goal_time = $request->goal_time;
        $businessAppointmentRequest->phone = $request->phone;
        $businessAppointmentRequest->email = $request->email;
        $businessAppointmentRequest->contact_type = $request->contact_type;
        $businessAppointmentRequest->note = $request->note;
        $businessAppointmentRequest->user_name = $request->user_name;
        $businessAppointmentRequest->added_services = $request->added_services;
        $businessAppointmentRequest->questions = $request->questions;
        $businessAppointmentRequest->ip_address = $request->ip();
        if ($businessAppointmentRequest->save()){
            return back()->with('response', [
               'status' => "success",
               'message' => "Talebiniz İşletmeye İletildi. İşletme Size En Kısa Süre İçerisinde Dönüş Yapacaktır"
            ]);
        }
        return back()->with('response', [
            'status' => "error",
            'message' => "Talebiniz sistemsel bir hata sebebi ile oluşturulamadı."
        ]);
    }
}
