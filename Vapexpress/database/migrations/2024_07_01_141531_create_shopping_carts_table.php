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
        Schema::create('shopping_carts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            #Lo relacionamos con el usuario
            $table->foreignId('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');
            #El precio total del carrito de la compra
            $table->float('total_price')->default(0);
            #Cantidad de productos del carrito de la compra
            $table->integer('total_products')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_carts');
    }
};
