<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function services()
    {

        return $this->belongsToMany(Service::class, 'offer_service', 'offer_id', 'service_id');
    }
}
