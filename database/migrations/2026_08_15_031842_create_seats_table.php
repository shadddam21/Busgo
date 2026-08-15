<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->string('seat_number', 5);
            $table->string('status', 20)->default('available'); // available, booked
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('seats'); }
};