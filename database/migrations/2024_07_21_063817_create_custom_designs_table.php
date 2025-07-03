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
        Schema::create('custom_designs', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('order_id');
            $table->string('custom_color')->nullable();
            $table->text('design_details')->nullable();
            $table->enum('neck_level', ['Yes', 'No'])->nullable();
            $table->text('neck_level_details')->nullable();
            $table->text('neck_level_design')->nullable();
            $table->text('swing_tag_design')->nullable();
            $table->enum('right_sleeve', ['Yes', 'No'])->nullable();
            $table->text('right_sleeve_details')->nullable();
            $table->text('right_sleeve_design')->nullable();
            $table->enum('left_sleeve', ['Yes', 'No'])->nullable();
            $table->text('left_sleeve_details')->nullable();
            $table->text('left_sleeve_design')->nullable();
            $table->enum('swing_tag', ['Yes', 'No'])->nullable();
            $table->text('swing_tag_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_designs');
    }
};
