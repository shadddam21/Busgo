<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Route extends Model {
    protected $guarded = [];
    public function origin() { return $this->belongsTo(City::class, 'origin_city_id'); }
    public function destination() { return $this->belongsTo(City::class, 'destination_city_id'); }
    public function schedules() { return $this->hasMany(Schedule::class); }
}