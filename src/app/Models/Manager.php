<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Manager extends Authenticatable
{
    use HasFactory;
 
    protected $guarded = ['id'];
    protected $fillable = [
        'shop_id',
        'name',
        'email',
        'email_verified_at',
        'password',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
