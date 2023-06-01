<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;
    protected $table = 'access_logs';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
    ];

    public function Customer()
    {
        return $this->belongsTo(User::class,'user_id','CusID');
    }
}
