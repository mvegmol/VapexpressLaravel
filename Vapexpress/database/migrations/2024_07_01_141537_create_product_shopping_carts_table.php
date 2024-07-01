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
        Schema::create('product_shopping_carts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            #id del producto
            $table->foreignId('product_id')->references('id')->on('products')->constrained()->onDelete('cascade');
            #id del carrito de la compra
            $table->foreignId('shopping_cart_id')->references('id')->on('shopping_carts')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->float('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_shopping_carts');
    }
};
