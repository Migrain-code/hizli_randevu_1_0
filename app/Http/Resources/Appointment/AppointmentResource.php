<?php

namespace App\Http\Resources\Appointment;

use App\Http\Resources\Business\BusinessListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       return [
            'id' => $this->id,
            'business' => BusinessListResource::make($this->business),
            'service' => $this->getServiceName(),
            'date' => $this->start_time->format('d.m.y H:i'),
            'status' => $this->status("text"),
            'statusColor' => $this->status("color"),
            'total' => $this->calculateTotal(), // toplam
            'collectedTotal' => $this->calculateTotal() // kalan
        ];
    }

    public function getServiceName()
    {
        $apService = $this->services->first();

        if (isset($apService) && isset($apService->service) && isset($apService->service->subCategory)) {
            $serviceName = $apService->service->subCategory->name;

            // Ek hizmetler varsa adı güncelle
            if ($this->services->count() > 1) {
                $serviceName .= " +" . ($this->services->count() - 1);
            }
        } else {
            // Hata döndür veya varsayılan bir işlem gerçekleştir
            $serviceName = "Hizmet silinmiş";
        }

        return $serviceName;
    }

}
