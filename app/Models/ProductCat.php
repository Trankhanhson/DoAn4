<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    use HasFactory;
    protected $table = 'productcat';
    protected $primaryKey = 'ProCatId';
    protected $filltable = ['ProCatId', 'Name', 'CatID', 'Image', 'Active'];

    public function category(){
        return $this->belongsTo(Category::class,'CatID','CatID');
    }
}
