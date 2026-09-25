<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        // Add these two lines
        $table->string('customer_name')->nullable()->after('id');
        $table->string('customer_phone')->nullable()->after('customer_name');
        
        // Optional: Make customer_id nullable since you might not always have a registered customer
        $table->foreignId('customer_id')->nullable()->change();
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['customer_name', 'customer_phone']);
    });
}
};
