<?php

namespace App\Models;

use App\Models\Spect;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spectitem extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected function spects(){
        return $this->belongsTo(Spect::class);
    }
    protected function products(){
        return $this->belongsToMany(Product::class);
    }
}
