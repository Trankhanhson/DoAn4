<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportBillDetail extends Model
{
    use HasFactory;
    protected $table = 'importbilldetail';
    protected $filltable = ['ProVariationID', 'ImpId', 'Quantity', 'ImportPrice'];

    public function ImportBill(){
        return $this->belongsTo(ImportBill::class,'ImpId','ImpId');
    }
    public function ProductVariation(){
        return $this->belongsTo(ProductVariation::class,'ProVariationID','ProVariationID');
    }
}
