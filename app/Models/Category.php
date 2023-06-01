<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $primaryKey = 'CatID';
    protected $filltable = ['CatID', 'Name', 'type', 'Active'];

    public function ProductCats(){
        return $this->hasMany(ProductCat::class,'CatID','CatID');
    }
}
