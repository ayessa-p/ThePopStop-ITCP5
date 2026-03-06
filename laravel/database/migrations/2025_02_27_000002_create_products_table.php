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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('series');
            $table->string('brand');
            $table->decimal('price', 10, 2);
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->string('character')->nullable();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('status', ['In Stock', 'Low Stock', 'Out of Stock'])->default('Out of Stock');
            $table->timestamps();
            $table->softDeletes();
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
