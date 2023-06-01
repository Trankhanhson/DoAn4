<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;
    protected $table = 'productsize';
    protected $primaryKey = 'ProSizeID';
    protected $filltable = ['ProSizeID', 'NameSize', 'updated_at', 'created_at'];

}
