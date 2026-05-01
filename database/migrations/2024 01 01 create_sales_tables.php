<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
    $table->id();
    $table->string('reference_no')->unique();
    $table->string('customer_name')->nullable();
    $table->string('payment_method');
    $table->decimal('total', 10, 2);
    $table->decimal('amount_tendered', 10, 2)->nullable();
    $table->decimal('change', 10, 2)->nullable();
    $table->timestamps();
});
       Schema::create('sale_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
    $table->foreignId('product_id')->constrained();
    $table->integer('quantity');
    $table->decimal('unit_price', 10, 2);
    $table->decimal('subtotal', 10, 2);
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
    }
};