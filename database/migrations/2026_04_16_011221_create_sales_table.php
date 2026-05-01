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
    if (!Schema::hasTable('sales')) {
        Schema::create('sales', function (Blueprint $table) {   
        $table->id();
        $table->string('reference')->unique();
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->integer('quantity');    
        $table->decimal('unit_price', 10, 2);
        $table->decimal('total', 10, 2);
        $table->string('cashier')->nullable();
        $table->string('status')->default('Paid');
        $table->timestamps();
    });
}

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};