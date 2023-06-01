<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportProduct extends Model
{
    use HasFactory;
    
    protected $table = 'reportproduct';
    protected $primaryKey = 'ReportProductId';
    protected $filltable = ['ReportProductId', 'ProId', 'ProColorID', 'Revenue', 'Profit', 'Quantity', 'Date'];

    public function Product(){
        return $this->belongsTo(Product::class,'ProId','ProId');
    }

    public function ProductColor(){
        return $this->belongsTo(ProductColor::class,'ProColorID','ProColorID');
    }
}
