<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountDetail extends Model
{
    use HasFactory;
    protected $table = 'discountdetail';
    protected $primaryKey = 'DiscountDetailId';
    protected $filltable = ['DiscountDetailId', 'ProId', 'DiscountProductId', 'Amount', 'TypeAmount', 'priceAfter'];

    public function DiscountProduct(){
        return $this->belongsTo(DiscountProduct::class,'DiscountProductId','DiscountProductId');
    }
    public function Product(){
        return $this->belongsTo(Product::class,'ProId','ProId');
    }
}
