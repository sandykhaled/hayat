<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'     => $this->id,
            'name_ar'  => $this->name_ar,
            'name_en'    => $this->name_en,
            'address_ar'   => $this->address_ar,
            'address_en'    => $this->address_en,
            'image'          => $this->image,
            'location_url'    => $this->location_url,
        ];
    }


    }

