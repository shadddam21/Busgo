<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 20)->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('schedule_id')->constrained();
            $table->foreignId('seat_id')->constrained();
            $table->decimal('total_price', 12, 2);
            $table->string('status', 20)->default('pending'); // pending, paid, confirmed, cancelled, departed
            $table->string('qr_token', 100)->unique()->nullable();
            $table->boolean('is_qr_used')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};