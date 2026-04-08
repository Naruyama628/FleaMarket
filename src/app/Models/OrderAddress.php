<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'postal_code',
        'address',
        'building',
    ];

    protected $casts = [
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

