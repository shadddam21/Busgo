<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Seat extends Model {
    protected $guarded = [];
    public function schedule() { return $this->belongsTo(Schedule::class); }
    public function order() { return $this->hasOne(Order::class); }
}