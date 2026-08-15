<?php
$models = [
    'City' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass City extends Model {\n    protected \$guarded = [];\n    public function originRoutes() { return \$this->hasMany(Route::class, 'origin_city_id'); }\n    public function destinationRoutes() { return \$this->hasMany(Route::class, 'destination_city_id'); }\n}",
    'Route' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass Route extends Model {\n    protected \$guarded = [];\n    public function origin() { return \$this->belongsTo(City::class, 'origin_city_id'); }\n    public function destination() { return \$this->belongsTo(City::class, 'destination_city_id'); }\n    public function schedules() { return \$this->hasMany(Schedule::class); }\n}",
    'Schedule' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass Schedule extends Model {\n    protected \$guarded = [];\n    public function route() { return \$this->belongsTo(Route::class); }\n    public function seats() { return \$this->hasMany(Seat::class); }\n    public function orders() { return \$this->hasMany(Order::class); }\n}",
    'Seat' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass Seat extends Model {\n    protected \$guarded = [];\n    public function schedule() { return \$this->belongsTo(Schedule::class); }\n    public function order() { return \$this->hasOne(Order::class); }\n}",
    'Order' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass Order extends Model {\n    protected \$guarded = [];\n    public function schedule() { return \$this->belongsTo(Schedule::class); }\n    public function user() { return \$this->belongsTo(User::class); }\n    public function seat() { return \$this->belongsTo(Seat::class); }\n    public function payment() { return \$this->hasOne(Payment::class); }\n}",
    'Payment' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass Payment extends Model {\n    protected \$guarded = [];\n    public function order() { return \$this->belongsTo(Order::class); }\n    public function user() { return \$this->belongsTo(User::class); }\n}"
];
foreach($models as $name => $content) {
    file_put_contents('app/Models/' . $name . '.php', $content);
}
echo 'Models updated';
