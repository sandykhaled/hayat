<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {



        return [
            'title_ar'=> $this->title_ar,
            'title_en'=> $this->title_en,
            'description_ar'=>$this->description_ar,
            'description_en'=>$this->description_en,
           'images' => $this->whenLoaded('images')->map(function ($image) {
                return asset('uploads/blogs/' . $image->image);
            }), ];
    }
}
