<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'productimage';
    protected $primaryKey = 'ProImageId';
    protected $filltable = ['ProImageId','ProColorID', 'ProId', 'Image', 'DetailImage1', 'DetailImage2', 'DetailImage3', 'DetailImage4', 'ImageColor', 'DetailImage5','StatusImage', 'StatusDetailImage1', 'StatusDetailImage2', 'StatusDetailImage3', 'StatusDetailImage4', 'StatusDetailImage5'];
    public function ProductColor(){
        return $this->belongsTo(ProductColor::class,'ProColorID','ProColorID');
    }
    public function Product(){
        return $this->belongsTo(Product::class,'ProId','ProId');
    }
}
