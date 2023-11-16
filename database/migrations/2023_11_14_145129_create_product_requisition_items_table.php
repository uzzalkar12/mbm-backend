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
        Schema::create('product_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_requisition_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->string('requested_quantity');
            $table->float('requested_amount')->default(0);
            $table->string('requested_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requisition_items');
    }
};
