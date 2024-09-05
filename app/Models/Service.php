<?php

namespace App\Models;

use App\Models\Offer;
use App\Models\Clients;
use App\Models\ClientFollowUps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_service', 'service_id', 'offer_id');
    }

    public function clients()
    {
        return $this->hasMany(Clients::class);
    }


    public function ClientfollowUps()
    {
        return $this->hasMany(ClientFollowUps::class, 'service_id');
    }

}
