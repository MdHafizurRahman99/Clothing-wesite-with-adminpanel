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
            $table->string('id')->primary(); // Define 'id' as primary key of type string
            $table->string('product_for')->nullable();
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->string('customcolor')->nullable();
            $table->string('minimum_order')->nullable();
            $table->string('minimum_time_required')->nullable();
            $table->string('size')->nullable(); // for single size per product
            $table->string('pattern_id');
            $table->string('category_id');
            $table->text('image')->nullable();
            $table->string('design_image_front_side')->nullable();
            $table->string('design_image_back_side')->nullable();
            $table->string('design_image_right_side')->nullable();
            $table->string('design_image_left_side')->nullable();
            $table->text('description')->nullable();
            $table->string('weight')->nullable();
            $table->string('gender')->nullable();
            $table->string('productsizetype')->nullable();
            $table->string('price')->nullable();
            $table->string('fabric')->nullable();
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
