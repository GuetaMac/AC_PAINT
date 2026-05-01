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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('brand');
        $table->string('category');
        $table->string('product_code')->nullable()->after('id');
        $table->string('size');
        $table->decimal('price', 10, 2);
        $table->integer('stock')->default(0);
        $table->integer('min_stock')->default(5);
        $table->string('supplier')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
