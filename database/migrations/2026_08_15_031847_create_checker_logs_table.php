<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('checker_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('user_id')->constrained(); // checker
            $table->timestamp('scanned_at');
            $table->string('status', 20); // valid, invalid
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('checker_logs'); }
};