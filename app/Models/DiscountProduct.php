<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountProduct extends Model
{
    use HasFactory;
    protected $table = 'discountproduct';
    protected $primaryKey = 'DiscountProductId';
    protected $filltable = ['DiscountProductId', 'Name', 'StartDate', 'EndDate'];

    public function DiscountDetails(){
        return $this->hasMany(DiscountDetail::class,'DiscountProductId','DiscountProductId');
    }
}
