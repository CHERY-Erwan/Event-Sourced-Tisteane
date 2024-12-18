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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('product_uuid');
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->json('size')->nullable();
            $table->json('color')->nullable();
            $table->integer('price');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('product_uuid')->references('uuid')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('product_variants');
        Schema::enableForeignKeyConstraints();
    }
};
