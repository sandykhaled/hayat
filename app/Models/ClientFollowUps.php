<?php

namespace App\Models;

use App\Models\User;
use App\Models\Clients;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;

class ClientFollowUps extends Model
{
    //
    protected $guarded = [];



    public function ContactingType()
    {
        $arr = [
            'Mail' => 'بريد إلكتروني',
            'Call' => 'إتصال هاتفي',
            'InVisit' => 'زياره بمقر الشركة',
            'OutVisit' => 'زياره بمقر العميل',
            'UnitVisit' => 'معاينة للوحدة'
        ];

    }
    public function client()
    {
        return $this->belongsTo(Clients::class,'ClientID');
    }
    public function agent()
    {
        return $this->belongsTo(User::class,'UID');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
