<?php

namespace App\Models;

use App\Models\Categorie;
use App\Models\Spectitem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spect extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }

    public function spectsItems(){
        return $this->hasMany(Spectitem::class);
    }

}
