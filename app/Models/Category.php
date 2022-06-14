<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'category_name',

    ];

    protected $dates = ['deleted_at'];
    public function images()
    {
        return $this->hasMany('App\Models\GalleryImage');
    }
}
