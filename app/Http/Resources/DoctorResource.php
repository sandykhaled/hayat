<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
   return [
            'name'=> $this->name,
            'jobTitle'=>$this->jobTitle,
            'links'=> ['whatsapp'=>$this->whatsappLink,
            'linkedIn'=>$this->linkedinLink,
            'twitter'=>$this->twitterLink,],
            'photo' => $this->getFileLink('photo'),
        ];;
    }
}
