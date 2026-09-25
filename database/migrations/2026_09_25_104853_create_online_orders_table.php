<?php
// database/migrations/2026_01_02_000000_create_online_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('online_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();

            // Customer details
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('delivery_address'); // pickup/collection address

            // Services — summary fields for the admin table, full breakdown in items
            $table->string('service_name');      // e.g. "Wash & Fold, Dry Cleaning"
            $table->decimal('quantity', 8, 2);   // sum of all item quantities
            $table->json('items');               // [{service_id,name,price,unit,quantity,subtotal}, ...]

            // Pickup schedule
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->text('notes')->nullable();

            // Money + status
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('status')->default('pending');         // pending, processing, ready, completed, delivered, cancelled

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_orders');
    }
};