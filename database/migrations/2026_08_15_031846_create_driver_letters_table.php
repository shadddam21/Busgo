<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('driver_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained();
            $table->foreignId('user_id')->constrained(); // admin who created
            $table->string('driver_name');
            $table->string('license_number');
            $table->string('police_number');
            $table->string('vehicle_type');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('driver_letters'); }
};