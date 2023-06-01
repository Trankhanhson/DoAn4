<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
    protected $table = 'productvariation';
    protected $primaryKey = 'ProVariationID';
    protected $filltable = ['ProVariationID', 'ProId', 'ProSizeID', 'ProColorID', 'Ordered', 'Quantity', 'Status', 'MinimumQuantity', 'DisplayImage'];
    public function Product(){
        return $this->belongsTo(Product::class,'ProId','ProId');
    }
    public function ProductColor(){
        return $this->belongsTo(ProductColor::class,'ProColorID','ProColorID');
    }
    public function ProductSize(){
        return $this->belongsTo(ProductSize::class,'ProSizeID','ProSizeID');
    }

    public function OrderDetail(){
        return $this->belongsTo(OrderDetail::class,'ProVariationID','ProVariationID');
    }

    public function Feedback(){
        return $this->belongsTo(Feedback::class,'ProVariationID','ProVariationID');
    }
}
