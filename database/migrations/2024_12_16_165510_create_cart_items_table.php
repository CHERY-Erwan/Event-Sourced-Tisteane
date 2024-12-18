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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('cart_uuid');
            $table->uuid('product_variant_uuid')->nullable();
            $table->uuid('bundle_uuid')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('cart_uuid')->references('uuid')->on('carts')->onDelete('cascade');
            $table->foreign('product_variant_uuid')->references('uuid')->on('product_variants')->onDelete('cascade');
            $table->foreign('bundle_uuid')->references('uuid')->on('bundles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
