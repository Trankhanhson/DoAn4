<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $primaryKey = 'ProId';
    protected $filltable = ['ProId', 'ProCatId', 'ProName', 'Material', 'Description', 'Price', 'ImportPrice','Status', 'ImportDate', 'TotalQty', 'DiscountPrice', 'Percent','firstImage', 'Saled','DiscountAmount','TypeAmount','created_at'];
    public function ProductCat(){
        return $this->belongsTo(ProductCat::class,'ProCatId','ProCatId');
    }

    public function ProductImages(){
        return $this->hasMany(ProductImage::class,'ProId','ProId');
    }

    public function ProductVariations(){
        return $this->hasMany(ProductVariation::class,'ProId','ProId');
    }
}
