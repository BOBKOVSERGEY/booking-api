<?php

namespace App\Http\Resources;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'type' => $this->apartment_type?->name,
            'size' => $this->size,
            'beds_list' => $this->beds_list, // coming soon
            'bathrooms' => $this->bathrooms,
            'facilities' => FacilityResource::collection($this->whenLoaded('facilities')),
            'price' => $this->calculatePriceForDates($request->start_date, $request->end_date)
        ];
    }
}
