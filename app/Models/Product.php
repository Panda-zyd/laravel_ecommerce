<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Spect;
use App\Models\Categorie;
use App\Models\Spectitem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function productspectitems(){
        return $this->belongsToMany(Spectitem::class);
    }




}
