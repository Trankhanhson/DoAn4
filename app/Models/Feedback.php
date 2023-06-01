<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    
    protected $table = 'feedback';
    protected $primaryKey = 'FeedbackId';
    protected $filltable = ['FeedbackId', 'CusID', 'ProVariationID', 'Stars', 'Content', 'Image', 'Status', 'Datetime'];

    public function ProductVariation(){
        return $this->belongsTo(ProductVariation::class,'ProVariationID','ProVariationID');
    }

    public function Customer(){
        return $this->belongsTo(Customer::class,'CusID','CusID');
    }
}
