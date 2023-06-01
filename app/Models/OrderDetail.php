<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    
    protected $table = 'orderdetail';
    protected $filltable = ['ProVariationID', 'OrdID', 'Quantity', 'DiscountPrice', 'Price'];

    public function Order(){
        return $this->belongsTo(Order::class,'OrdID','OrdID');
    }
    public function ProductVariation(){
        return $this->belongsTo(ProductVariation::class,'ProVariationID','ProVariationID');
    }


}
