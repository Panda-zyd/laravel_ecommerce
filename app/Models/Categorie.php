<?php

namespace App\Models;

use App\Models\Spect;
use App\Models\Spectitem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function spects(){
        return $this->hasMany(Spect::class);
    }

    public function itemSpects(){
            return $this->hasManyThrough(Spectitem::class,Spect::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }

}
