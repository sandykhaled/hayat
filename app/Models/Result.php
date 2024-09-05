<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;


    protected $fillable = ['name_ar', 'name_en', 'start', 'end', 'video' ,'description_ar', 'description_en'];


    public function getFileLink()
    {
        return $this->video != null ? asset('uploads/results/' . $this->video) : '';
    }

}
