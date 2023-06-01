<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportBill extends Model
{
    use HasFactory;

    protected $table = 'importbill';
    protected $primaryKey = 'ImpId';
    protected $filltable = ['ImpId', 'StaffId', 'MoneyTotal','created_at'];

    public function ImportBillDetails(){
        return $this->hasMany(ImportBillDetail::class,'ImpId','ImpId');
    }

    public function User(){
        return $this->belongsTo(User::class,'StaffId','id');
    }
}
