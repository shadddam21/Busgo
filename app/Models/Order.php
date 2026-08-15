<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
    protected $guarded = [];
    public function schedule() { return $this->belongsTo(Schedule::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function seat() { return $this->belongsTo(Seat::class); }
    public function payment() { return $this->hasOne(Payment::class); }
}