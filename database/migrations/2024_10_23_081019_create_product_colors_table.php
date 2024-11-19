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
        if (!Schema::hasTable('product_colors')) {

            Schema::create('product_colors', function (Blueprint $table) {
                $table->id();
                $table->string('product_id');
                $table->string('color_id');
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');

                // Unique constraint to prevent duplicate entries
                $table->unique(['product_id', 'color_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_colors');
    }
};
