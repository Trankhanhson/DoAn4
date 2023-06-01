<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statusorder extends Model
{
    use HasFactory;
    protected $table = 'statusorder';
    protected $primaryKey = 'StatusOrderId';
    protected $filltable = ['StatusOrderId', 'Status'];
}
