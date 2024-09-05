<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebServiceResource extends JsonResource
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
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'image' => $this->getFileLink('image'),
            'description_ar' => strip_tags($this->description_ar),
            'description_en' => strip_tags($this->description_en),
            'price' => $this->price,
            'contact'   => $this->contact,
            'category' => $this->category == 'remote' ? 'خدمة عن بعد' : 'خدمة من المقر',
        ];
    }

}
