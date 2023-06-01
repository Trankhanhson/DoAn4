<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistical extends Model
{
    use HasFactory;
    protected $table = 'statistical';
    protected $primaryKey = 'statisticalId';
    protected $filltable = ['statisticalId', 'Date', 'Revenue', 'Profit', 'Quantity', 'Total_Order'];
}
