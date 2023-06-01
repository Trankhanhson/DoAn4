<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $primaryKey = 'OrdID';
    protected $filltable = ['OrdID', 'CusID', 'VoucherId', 'ReceivingName', 'ReceivingPhone', 'ReceivingCity', 'ReceivingDistrict', 'ReceivingWard', 'ReceivingAddress', 'PaymentType', 'StatusOrderId', 'MoneyTotal', 'OrderDate', 'Note'];

    public function OrderDetails(){
        return $this->hasMany(OrderDetail::class,'OrdID','OrdID');
    }

    public function Customer(){
        return $this->belongsTo(Customer::class,'CusID','CusID');
    }

    public function StatusOrder(){
        return $this->belongsTo(StatusOrder::class,'StatusOrderId','StatusOrderId');
    }
    
}
