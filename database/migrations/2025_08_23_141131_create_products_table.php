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
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->text('description')->nullable();
            $table->text('images');
            $table->json('variants');
            $table->integer('base_price');
            $table->integer('sale_price')->nullable();
            $table->boolean('is_tax')->default(false)->comment('Áp dụng thuế');
            $table->boolean('is_in_stock')->default(false)->comment('Còn hàng');
            $table->bigInteger('supplier_id')->unsigned()->comment('Nhà cung cấp');
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('collection_id')->unsigned();
            $table->enum('status', ['draft', 'scheduled', 'published'])->default('published');
            $table->softDeletes();
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
