<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogImg extends Model
{
    use HasFactory;
    protected $fillable = ['blog_id','image'];
    public function blog(){
        return $this->belongTo(Blog::class);
    }
}
