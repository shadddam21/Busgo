<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained();
            $table->string('bank_name', 100);
            $table->string('account_name', 100);
            $table->decimal('amount', 12, 2);
            $table->string('proof_image');
            $table->string('status', 20)->default('pending'); // pending, verified, rejected
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payments'); }
};