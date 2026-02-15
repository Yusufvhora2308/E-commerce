<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // Product name
            $table->string('sku')->unique();              // Stock Keeping Unit
            $table->text('description');                  // Product description
            $table->decimal('price', 10, 2);             // Price
            $table->decimal('discount', 5, 2)->default(0); // Discount
            $table->integer('stock')->default(0);        // Quantity available
            $table->string('image');                      // Main image
            $table->string('weight')->nullable();         // Weight info
            $table->string('dimensions')->nullable();     // Dimensions info
            $table->string('warranty')->nullable();      // Warranty info
            $table->boolean('featured')->default(false); // Featured product
            $table->decimal('rating', 3, 2)->default(0); // Average rating
            $table->enum('status', ['active', 'inactive'])->default('active'); // Visibility

            // SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Foreign keys
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');

            // Foreign Key Constraints
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categoryys')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
