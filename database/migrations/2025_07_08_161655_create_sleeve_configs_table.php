<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSleeveConfigsTable extends Migration
{
    public function up()
    {
        Schema::create('sleeve_configs', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->enum('side', ['left', 'right']);
            $table->float('left_image_left');
            $table->float('left_image_rotate');
            $table->float('sleeve_top');
            $table->float('left_image_right');
            $table->float('left_image_right_rotate');
            $table->float('right_image_left');
            $table->float('right_image_rotate');
            $table->float('right_image_right');
            $table->float('right_image_right_rotate');
            $table->timestamps();

            $table->unique(['product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sleeve_configs');
    }
}
