<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'CusID';
    protected $filltable = ['CusID', 'Name', 'Phone', 'ResetPasswordCode', 'Password', 'Email', 'Address', 'Status'];

}
