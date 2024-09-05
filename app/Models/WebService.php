<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebService extends Model
{
    use HasFactory;

    protected $fillable = ['name_ar', 'name_en', 'description_ar', 'description_en', 'image', 'price', 'contact'];


    public function getFileLink()
    {
        return $this->image != null ? asset('uploads/Webservices/' . $this->image) : '';

    }
}
