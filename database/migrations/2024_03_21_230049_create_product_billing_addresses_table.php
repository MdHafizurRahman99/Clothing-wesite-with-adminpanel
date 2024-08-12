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
        Schema::create('product_billing_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_name')->nullable();
            $table->string('email');
            $table->string('mobile');
            $table->string('address');
            $table->string('country');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('ship_to_different_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_billing_addresses');
    }
};
