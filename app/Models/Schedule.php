<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Schedule extends Model {
    protected $guarded = [];
    public function route() { return $this->belongsTo(Route::class); }
    public function seats() { return $this->hasMany(Seat::class); }
    public function orders() { return $this->hasMany(Order::class); }
}