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
        Schema::create('custom_orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('target');
            $table->string('category');
            $table->string('subcategory')->nullable();
            $table->string('looking_for');
            $table->string('additional_services')->nullable();
            $table->string('number_of_products');
            $table->string('quantity_per_model');
            $table->string('project_budget');
            $table->string('sample_delivery_date');
            $table->string('production_delivery_date');
            $table->text('project_description')->nullable();
            $table->string('payment_status')->default('Pending');
            $table->string('user_id');

            // $table->string('user_id');
            // $table->string('name');
            // $table->string('email');
            // $table->string('phone')->nullable();
            // $table->string('clothing_type');
            // $table->text('specific_preferences')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_orders');
    }
};
