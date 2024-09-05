<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\Service;
use App\Models\Revenues;
use App\Models\ClientFollowUps;
use Illuminate\Database\Eloquent\Model;


class Clients extends Model
{
    protected $guarded = [];
    //
    public function followups()
    {
        return $this->hasMany(ClientFollowUps::class,'ClientID');
    }
    public function lastFollowUp()
    {
        return $this->followups()->orderBy('id','desc')->first();
    }

    public function service()
{
    return $this->belongsTo(Service::class);
}

public function payment()
{
    return $this->hasOne(Payment::class);
}

public function revenues()
{
    return $this->hasMany(Revenues::class);
}
}
