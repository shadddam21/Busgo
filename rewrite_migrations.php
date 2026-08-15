<?php

$dir = __DIR__ . '/database/migrations/';
$files = scandir($dir);

$migrations = [
    'create_users_table' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->string('email')->unique();
            \$table->timestamp('email_verified_at')->nullable();
            \$table->string('password');
            \$table->string('role', 20)->default('customer');
            \$table->string('nik', 20)->nullable();
            \$table->string('phone', 20)->nullable();
            \$table->string('avatar')->nullable();
            \$table->rememberToken();
            \$table->timestamps();
        });
        Schema::create('password_reset_tokens', function (Blueprint \$table) {
            \$table->string('email')->primary();
            \$table->string('token');
            \$table->timestamp('created_at')->nullable();
        });
        Schema::create('sessions', function (Blueprint \$table) {
            \$table->string('id')->primary();
            \$table->foreignId('user_id')->nullable()->index();
            \$table->string('ip_address', 45)->nullable();
            \$table->text('user_agent')->nullable();
            \$table->longText('payload');
            \$table->integer('last_activity')->index();
        });
    }
    public function down(): void {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
PHP,

    'create_cities_table' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('cities', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('cities'); }
};
PHP,

    'create_routes_table' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('routes', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('origin_city_id')->constrained('cities');
            \$table->foreignId('destination_city_id')->constrained('cities');
            \$table->decimal('price', 12, 2);
            \$table->string('duration');
            \$table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('routes'); }
};
PHP,

    'create_schedules_table' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('schedules', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('route_id')->constrained();
            \$table->date('departure_date');
            \$table->time('departure_time');
            \$table->time('arrival_time');
            \$table->decimal('price', 12, 2);
            \$table->integer('total_seats');
            \$table->boolean('is_locked')->default(false);
            \$table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('schedules'); }
};
PHP,

    'create_seats_table' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('seats', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            \$table->string('seat_number', 5);
            \$table->string('status', 20)->default('available'); // available, booked
            \$table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('seats'); }
};
PHP,

    'create_orders_table' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint \$table) {
            \$table->id();
            \$table->string('order_code', 20)->unique();
            \$table->foreignId('user_id')->constrained();
            \$table->foreignId('schedule_id')->constrained();
            \$table->foreignId('seat_id')->constrained();
            \$table->decimal('total_price', 12, 2);
            \$table->string('status', 20)->default('pending'); // pending, paid, confirmed, cancelled, departed
            \$table->string('qr_token', 100)->unique()->nullable();
            \$table->boolean('is_qr_used')->default(false);
            \$table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};
PHP,

    'create_payments_table' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('order_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('user_id')->constrained();
            \$table->string('bank_name', 100);
            \$table->string('account_name', 100);
            \$table->decimal('amount', 12, 2);
            \$table->string('proof_image');
            \$table->string('status', 20)->default('pending'); // pending, verified, rejected
            \$table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payments'); }
};
PHP,

    'create_driver_letters_table' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('driver_letters', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('schedule_id')->constrained();
            \$table->foreignId('user_id')->constrained(); // admin who created
            \$table->string('driver_name');
            \$table->string('license_number');
            \$table->string('police_number');
            \$table->string('vehicle_type');
            \$table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('driver_letters'); }
};
PHP,

    'create_checker_logs_table' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('checker_logs', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('order_id')->constrained();
            \$table->foreignId('user_id')->constrained(); // checker
            \$table->timestamp('scanned_at');
            \$table->string('status', 20); // valid, invalid
            \$table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('checker_logs'); }
};
PHP
];

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    foreach ($migrations as $key => $content) {
        if (strpos($file, $key) !== false) {
            file_put_contents($dir . $file, $content);
            echo "Updated \$file\n";
        }
    }
}
