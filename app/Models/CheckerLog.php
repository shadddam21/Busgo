<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckerLog extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'scanned_at',
        'status',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
