<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_requisition_item_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_requisition_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('product_stock_id')->constrained();
            $table->foreignId('supplier_id')->constrained();
            $table->float('accept_quantity');
            $table->float('total_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requisition_item_details');
    }
};
