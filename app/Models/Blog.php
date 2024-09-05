<?php

namespace App\Models;

use App\Models\Image;
use App\Models\BlogImg;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;



    protected $fillable = ['title_ar',  'title_en', 'description_ar' , 'description_en' ,'image'];

  public function images(){
        return $this->hasMany(BlogImg::class);
    }
        public function getFileLink()
{
    return $this->images != null ? asset('uploads/blogs/' . $this->image) : '';
}
}
