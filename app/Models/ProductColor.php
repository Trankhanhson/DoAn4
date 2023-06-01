<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;
    protected $table = 'productcolor';
    protected $primaryKey = 'ProColorID';
    protected $filltable = ['ProColorID', 'NameColor', 'ImageColor', 'updated_at', 'created_at'];

}
