<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationCart extends Model
{
    use HasFactory;
    protected $filltable = ['ProId', 'proColorId', 'proSizeId', 'Price','DiscountPrice', 'Percent', 'ProName', 'Image', 'proSizeName','srcColor'];
}
