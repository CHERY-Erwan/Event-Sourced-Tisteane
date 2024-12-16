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
        Schema::create('bundle_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('bundle_id');
            $table->uuid('product_variant_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('bundle_id')->references('id')->on('bundles')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundle_items');
    }
};
