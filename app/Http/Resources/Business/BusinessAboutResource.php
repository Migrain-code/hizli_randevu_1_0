<?php

namespace App\Http\Resources\Business;

use App\Http\Resources\City\CityListResource;
use App\Http\Resources\City\DistrictListResource;
use App\Models\DayList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BusinessAboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'instagram' =>"https://instagram.com/".$this->instagram,
            'about' => $this->about,
            'embed' => $this->embed,
            'address' => $this->addresss,
            'workTimes' => $this->dayList()
        ];
    }

    public function dayList()
    {
        $dayList = DayList::all();
        $closeDays = [];
        foreach($dayList as $day){
            $closeDays[] = [
                'id' => $day->id,
                'name' => $day->name,
                'clock' => $this->start_time. " - ".$this->end_time,
                'status' => isset($this->off_day) && $day->id != $this->off_day
            ];
        }
        return $closeDays;
    }
}
