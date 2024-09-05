<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = ['name','jobTitle','linkedInLink','twitterLink','whatsappLink','photo'];

    public function getFileLink()
{
    return $this->photo != null ? asset('uploads/doctors/' . $this->photo) : '';
}
}
