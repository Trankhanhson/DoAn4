<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    protected $table = 'post';
    protected $primaryKey = 'PostId';
    protected $filltable = ['PostId', 'UserID', 'Title', 'Content', 'PublicDate', 'Image', 'Status'];

    public function User(){
        return $this->belongsTo(User::class,'UserID','id');
    }
}
