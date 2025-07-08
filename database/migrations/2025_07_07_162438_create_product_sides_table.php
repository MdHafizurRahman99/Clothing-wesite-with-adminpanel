<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSidesTable extends Migration
{
    public function up()
    {
        Schema::create('product_sides', function (Blueprint $table) {
            $table->id();
            $table->string('product_id'); // e.g., front, back, left_sleeve, right_sleeve
            $table->string('side'); // e.g., front, back, left_sleeve, right_sleeve
            // $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('template_image'); // Path to base image
            $table->json('design_area'); // {x, y, width, height}
            $table->json('adjacent_side_mappings'); // e.g., {"front": [{"side": "left_sleeve", "x": 405, "y": 220, "scale": 0.2, "rotation": -11}]}
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_sides');
    }
}
